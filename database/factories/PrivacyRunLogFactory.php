<?php

namespace ElvinQulizade\Gdpr\Database\Factories;

use ElvinQulizade\Gdpr\Enums\PrivacyRunStatus;
use ElvinQulizade\Gdpr\Models\PrivacyRunLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PrivacyRunLog>
 */
class PrivacyRunLogFactory extends Factory
{
    protected $model = PrivacyRunLog::class;

    public function definition(): array
    {
        return [
            'retention_policy_id' => RetentionPolicyFactory::new(),
            'status' => PrivacyRunStatus::Succeeded,
            'records_processed' => 0,
            'records_deleted' => 0,
            'records_anonymized' => 0,
            'started_at' => now()->subMinutes(2),
            'finished_at' => now()->subMinute(),
        ];
    }
}
