<?php

namespace ElvinQulizade\Gdpr\Database\Factories;

use ElvinQulizade\Gdpr\Enums\RetentionAction;
use ElvinQulizade\Gdpr\Enums\RetentionPeriodUnit;
use ElvinQulizade\Gdpr\Models\RetentionPolicy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RetentionPolicy>
 */
class RetentionPolicyFactory extends Factory
{
    protected $model = RetentionPolicy::class;

    public function definition(): array
    {
        return [
            'name' => 'Old records',
            'model_class' => 'App\Models\User',
            'retention_column' => 'created_at',
            'retention_period' => 12,
            'period_unit' => RetentionPeriodUnit::Months,
            'action' => RetentionAction::Anonymize,
            'anonymize_fields' => ['name' => 'mask', 'email' => 'mask'],
            'anonymize_values' => [],
            'enabled' => true,
        ];
    }

    public function destructive(): static
    {
        return $this->state([
            'action' => RetentionAction::Delete,
            'anonymize_fields' => [],
        ]);
    }
}
