<?php

namespace ElvinQulizade\Gdpr\Support;

use ElvinQulizade\Gdpr\Enums\PrivacyRunStatus;
use ElvinQulizade\Gdpr\Enums\RetentionAction;
use ElvinQulizade\Gdpr\Models\PrivacyRunLog;
use ElvinQulizade\Gdpr\Models\RetentionPolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Throwable;

class RetentionRunner
{
    public function __construct(
        protected Anonymizer $anonymizer = new Anonymizer,
    ) {}

    /**
     * Run all enabled policies (or a single one) against the target tables.
     *
     * @return array{policies: array<int, array<string, int>>, processed: int, deleted: int, anonymized: int}
     */
    public function run(?int $policyId = null, bool $dryRun = false): array
    {
        $policies = RetentionPolicy::query()
            ->when($policyId !== null, fn ($query) => $query->whereKey($policyId))
            ->where('enabled', true)
            ->get();

        $report = [
            'policies' => [],
            'processed' => 0,
            'deleted' => 0,
            'anonymized' => 0,
        ];

        foreach ($policies as $policy) {
            $counts = $dryRun
                ? $this->countFor($policy)
                : $this->runForPolicy($policy);

            $report['policies'][$policy->id] = $counts;
            $report['processed'] += $counts['processed'];
            $report['deleted'] += $counts['deleted'];
            $report['anonymized'] += $counts['anonymized'];
        }

        return $report;
    }

    /**
     * @return array{processed: int, deleted: int, anonymized: int}
     */
    protected function countFor(RetentionPolicy $policy): array
    {
        $count = $this->query($policy)->count();

        return [
            'processed' => $count,
            'deleted' => $policy->action === RetentionAction::Delete ? $count : 0,
            'anonymized' => $policy->action === RetentionAction::Anonymize ? $count : 0,
        ];
    }

    /**
     * @return array{processed: int, deleted: int, anonymized: int}
     */
    protected function runForPolicy(RetentionPolicy $policy): array
    {
        $counts = ['processed' => 0, 'deleted' => 0, 'anonymized' => 0];

        $log = PrivacyRunLog::create([
            'retention_policy_id' => $policy->id,
            'status' => PrivacyRunStatus::Running,
            'started_at' => now(),
        ]);

        try {
            $this->process($policy, $counts);

            $this->finishLog($log, PrivacyRunStatus::Succeeded, $counts, null);
        } catch (Throwable $e) {
            $this->finishLog($log, PrivacyRunStatus::Failed, $counts, $e->getMessage());

            throw $e;
        }

        return $counts;
    }

    /**
     * @param  array{processed: int, deleted: int, anonymized: int}  $counts
     */
    protected function process(RetentionPolicy $policy, array &$counts): void
    {
        $deleteMode = config('filament-gdpr.delete_mode', 'force');
        $fields = $policy->anonymizeFieldsMap();
        $values = $policy->anonymizeValuesMap();

        $this->query($policy)->orderBy('id')->chunkById(500, function ($records) use ($policy, $deleteMode, $fields, $values, &$counts) {
            foreach ($records as $record) {
                $counts['processed']++;

                if ($policy->action === RetentionAction::Delete) {
                    $this->deleteRecord($record, $deleteMode);
                    $counts['deleted']++;
                } else {
                    $this->anonymizer->anonymize($record, $fields, $values);
                    $counts['anonymized']++;
                }
            }
        });
    }

    protected function query(RetentionPolicy $policy): Builder
    {
        return $policy->targetModel()
            ->newQuery()
            ->where($policy->retention_column, '<', $policy->cutoff());
    }

    protected function deleteRecord(Model $record, string $deleteMode): void
    {
        $usesSoftDeletes = in_array(SoftDeletes::class, class_uses_recursive($record), true);

        if ($deleteMode === 'force' && $usesSoftDeletes) {
            $record->forceDelete();

            return;
        }

        $record->delete();
    }

    /**
     * @param  array{processed: int, deleted: int, anonymized: int}  $counts
     */
    protected function finishLog(PrivacyRunLog $log, PrivacyRunStatus $status, array $counts, ?string $error): void
    {
        $log->update([
            'status' => $status,
            'records_processed' => $counts['processed'],
            'records_deleted' => $counts['deleted'],
            'records_anonymized' => $counts['anonymized'],
            'error' => $error,
            'finished_at' => now(),
        ]);
    }
}
