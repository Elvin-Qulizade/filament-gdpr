<?php

namespace ElvinQulizade\Gdpr\Commands;

use ElvinQulizade\Gdpr\Support\RetentionRunner;
use Illuminate\Console\Command;

class PrivacyRunCommand extends Command
{
    public $signature = 'privacy:run
        {--policy= : Only run the policy with this ID}
        {--dry-run : Simulate the run without modifying data}';

    public $description = 'Run GDPR retention policies against your data';

    public function handle(RetentionRunner $runner): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $policyId = $this->option('policy');
        $policyId = $policyId !== null && $policyId !== '' ? (int) $policyId : null;

        $report = $runner->run($policyId, $dryRun);

        if ($report['policies'] === []) {
            $this->components->error('privacy:run: no enabled retention policies found.');

            return self::SUCCESS;
        }

        if ($report['processed'] === 0) {
            $this->components->info(($dryRun ? '[dry-run] ' : '') . 'No records match retention criteria.');

            return self::SUCCESS;
        }

        if ($dryRun) {
            $this->components->info('[dry-run] No records were modified.');
        }

        foreach ($report['policies'] as $id => $counts) {
            $this->components->twoColumnDetail(
                "Policy #{$id}",
                sprintf(
                    'processed: %s | deleted: %s | anonymized: %s',
                    $counts['processed'],
                    $counts['deleted'],
                    $counts['anonymized'],
                ),
            );
        }

        $this->components->info(sprintf(
            'Total — processed: %s, deleted: %s, anonymized: %s',
            $report['processed'],
            $report['deleted'],
            $report['anonymized'],
        ));

        return self::SUCCESS;
    }
}
