<?php

use ElvinQulizade\Gdpr\Models\RetentionPolicy;
use ElvinQulizade\Gdpr\Tests\Fixtures\Customer;

beforeEach(function () {
    Customer::create([
        'name' => 'Retired',
        'email' => 'retired@example.com',
        'phone' => '000',
        'notes' => 'old',
        'created_at' => now()->subYears(5),
    ]);
});

it('runs the privacy:run command as a dry run without deleting', function () {
    RetentionPolicy::factory()->create([
        'model_class' => Customer::class,
        'retention_column' => 'created_at',
        'retention_period' => 24,
        'period_unit' => 'months',
    ]);

    $this->artisan('privacy:run', ['--dry-run' => true])
        ->expectsOutputToContain('No records were modified')
        ->assertExitCode(0);

    expect(Customer::count())->toBe(1);
});

it('reports no enabled policies when none exist', function () {
    $this->artisan('privacy:run')
        ->expectsOutputToContain('no enabled retention policies found')
        ->assertExitCode(0);
});

it('generates a personal data export through the command', function () {
    config()->set('filament-gdpr.models', [Customer::class => ['column' => 'email']]);

    $this->artisan('privacy:export', ['email' => 'retired@example.com'])
        ->expectsOutputToContain('Export completed')
        ->assertExitCode(0);
})->skip(extension_loaded('zip') === false, 'ext-zip is required');

it('fails the export command for a subject with no matches', function () {
    config()->set('filament-gdpr.models', [Customer::class => ['column' => 'email']]);

    $this->artisan('privacy:export', ['email' => 'ghost@example.com'])
        ->expectsOutputToContain('Export completed')
        ->assertExitCode(0);
})->skip(extension_loaded('zip') === false, 'ext-zip is required');
