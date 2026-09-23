<?php

namespace ElvinQulizade\Gdpr\Models;

use ElvinQulizade\Gdpr\Database\Factories\RetentionPolicyFactory;
use ElvinQulizade\Gdpr\Enums\RetentionAction;
use ElvinQulizade\Gdpr\Enums\RetentionPeriodUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int|null $id
 * @property string $name
 * @property class-string $model_class
 * @property string $retention_column
 * @property int $retention_period
 * @property RetentionPeriodUnit $period_unit
 * @property RetentionAction $action
 * @property array<int, array<string, string>>|array<string, string> $anonymize_fields
 * @property array<int, array<string, string>>|array<string, string> $anonymize_values
 * @property bool $enabled
 * @property Carbon $created_at
 */
class RetentionPolicy extends Model
{
    /** @use HasFactory<RetentionPolicyFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $table = 'filament_gdpr_policies';

    protected function casts(): array
    {
        return [
            'retention_period' => 'integer',
            'anonymize_fields' => 'array',
            'anonymize_values' => 'array',
            'enabled' => 'boolean',
            'period_unit' => RetentionPeriodUnit::class,
            'action' => RetentionAction::class,
        ];
    }

    protected static function newFactory(): RetentionPolicyFactory
    {
        return RetentionPolicyFactory::new();
    }

    /**
     * @return HasMany<PrivacyRunLog, $this>
     */
    public function runLogs(): HasMany
    {
        return $this->hasMany(PrivacyRunLog::class, 'retention_policy_id');
    }

    public function cutoff(): Carbon
    {
        $now = Carbon::now();

        return match ($this->period_unit) {
            RetentionPeriodUnit::Days => $now->subDays($this->retention_period),
            RetentionPeriodUnit::Months => $now->subMonths($this->retention_period),
            RetentionPeriodUnit::Years => $now->subYears($this->retention_period),
        };
    }

    /**
     * @return array<string, string> field => strategy
     */
    public function anonymizeFieldsMap(): array
    {
        return self::mapFromRows($this->anonymize_fields ?? []);
    }

    /**
     * @return array<string, mixed> field => static value
     */
    public function anonymizeValuesMap(): array
    {
        return self::mapFromRows($this->anonymize_values ?? [], allowNull: true);
    }

    /**
     * @param  array<int|string, mixed>  $rows
     * @return array<string, mixed>
     */
    protected static function mapFromRows(array $rows, bool $allowNull = false): array
    {
        if (array_is_list($rows)) {
            $map = [];

            foreach ($rows as $row) {
                if (! is_array($row) || empty($row['field'])) {
                    continue;
                }

                $map[$row['field']] = $row['strategy'] ?? $row['value'] ?? ($allowNull ? null : 'mask');
            }

            return $map;
        }

        return $rows;
    }

    public function displayPeriod(): string
    {
        if ($this->retention_period === 1) {
            return sprintf('1 %s', mb_strtolower(rtrim($this->period_unit->value, 's')));
        }

        return "{$this->retention_period} {$this->period_unit->value}";
    }

    public function targetModel(): Model
    {
        return new $this->model_class;
    }
}
