<?php

use ElvinQulizade\Gdpr\Enums\PrivacyRunStatus;
use ElvinQulizade\Gdpr\Models\PrivacyRunLog;
use ElvinQulizade\Gdpr\Models\RetentionPolicy;
use ElvinQulizade\Gdpr\Support\RetentionRunner;
use ElvinQulizade\Gdpr\Tests\Fixtures\Customer;

beforeEach(function () {
    $this->oldCustomer = Customer::create([
        'name' => 'Old Person',
        'email' => 'old@example.com',
        'phone' => '111',
        'notes' => 'legacy',
        'created_at' => now()->subYears(3),
    ]);

    $this->freshCustomer = Customer::create([
        'name' => 'Fresh Person',
        'email' => 'fresh@example.com',
        'phone' => '222',
        'notes' => 'active',
        'created_at' => now()->subMonth(),
    ]);
});

it('anonymizes only records older than the retention period', function () {
    $policy = RetentionPolicy::factory()->create([
        'model_class' => Customer::class,
        'retention_column' => 'created_at',
        'retention_period' => 24,
        'period_unit' => 'months',
        'anonymize_fields' => ['name' => 'mask', 'phone' => 'mask', 'notes' => 'mask'],
    ]);

    $report = (new RetentionRunner)->run($policy->id);

    expect($report['processed'])->toBe(1)
        ->and($report['anonymized'])->toBe(1)
        ->and($this->oldCustomer->fresh()->name)->toBe('Ol***')
        ->and($this->freshCustomer->fresh()->name)->toBe('Fresh Person');

    $log = PrivacyRunLog::first();
    expect($log->retention_policy_id)->toBe($policy->id)
        ->and($log->status)->toBe(PrivacyRunStatus::Succeeded)
        ->and($log->records_processed)->toBe(1)
        ->and($log->records_anonymized)->toBe(1);
});

it('deletes records when the policy is destructive', function () {
    $policy = RetentionPolicy::factory()->destructive()->create([
        'model_class' => Customer::class,
        'retention_period' => 24,
        'period_unit' => 'months',
    ]);

    $report = (new RetentionRunner)->run($policy->id);

    expect($report['deleted'])->toBe(1)
        ->and(Customer::whereKey($this->oldCustomer->id)->exists())->toBeFalse()
        ->and(Customer::whereKey($this->freshCustomer->id)->exists())->toBeTrue();
});

it('does not touch data in dry-run mode', function () {
    $policy = RetentionPolicy::factory()->create([
        'model_class' => Customer::class,
        'retention_column' => 'created_at',
        'retention_period' => 24,
        'period_unit' => 'months',
    ]);

    $report = (new RetentionRunner)->run($policy->id, dryRun: true);

    expect($report['processed'])->toBe(1)
        ->and($report['deleted'])->toBe(0)
        ->and(Customer::whereKey($this->oldCustomer->id)->exists())->toBeTrue()
        ->and($this->oldCustomer->fresh()->name)->toBe('Old Person')
        ->and(PrivacyRunLog::count())->toBe(0);
});

it('ignores disabled policies', function () {
    RetentionPolicy::factory()->create([
        'model_class' => Customer::class,
        'retention_period' => 24,
        'enabled' => false,
    ]);

    $report = (new RetentionRunner)->run();

    expect($report['processed'])->toBe(0);
});

it('marks the run log as failed when processing throws', function () {
    $policy = RetentionPolicy::factory()->create([
        'model_class' => 'App\Models\DefinitelyNotRegistered',
        'retention_column' => 'created_at',
    ]);

    try {
        (new RetentionRunner)->run($policy->id);
    } catch (Throwable) {
        // expected
    }

    $log = PrivacyRunLog::first();

    expect($log->status)->toBe(PrivacyRunStatus::Failed)
        ->and($log->error)->not->toBeNull();
});
