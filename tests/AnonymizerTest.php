<?php

use ElvinQulizade\Gdpr\Enums\RetentionAction;
use ElvinQulizade\Gdpr\Models\RetentionPolicy;
use ElvinQulizade\Gdpr\Support\Anonymizer;
use ElvinQulizade\Gdpr\Tests\Fixtures\Customer;

beforeEach(function () {
    $this->customer = Customer::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '555-1234',
        'notes' => 'VIP',
    ]);
});

it('masks scalar fields but protects the primary key', function () {
    $changed = (new Anonymizer)->anonymize($this->customer, [
        'name' => 'mask',
        'phone' => 'mask',
        'notes' => 'mask',
    ]);

    expect($changed)->toBe(['name', 'phone', 'notes'])
        ->and($this->customer->fresh()->name)->toBe('Jo***')
        ->and($this->customer->fresh()->phone)->toBe('55***')
        ->and($this->customer->fresh()->notes)->toBe('VI***')
        ->and($this->customer->fresh()->email)->toBe('john@example.com');
});

it('protects unique/primary columns unless overwrite is enabled', function () {
    (new Anonymizer)->anonymize($this->customer, ['email' => 'mask']);

    expect($this->customer->fresh()->email)->toBe('john@example.com');

    (new Anonymizer)->allowUniqueOverwrite()->anonymize($this->customer, ['email' => 'mask']);

    expect($this->customer->fresh()->email)->toBe('j***@example.com');
});

it('supports null and static strategies', function () {
    (new Anonymizer)->anonymize($this->customer, [
        'notes' => 'null',
        'phone' => 'static',
    ], [
        'phone' => 'REDACTED',
    ]);

    expect($this->customer->fresh()->notes)->toBeNull()
        ->and($this->customer->fresh()->phone)->toBe('REDACTED');
});

it('keeps values that are already anonymized untouched', function () {
    $this->customer->update(['email' => 'j***@example.com']);

    $changed = (new Anonymizer)->allowUniqueOverwrite()->anonymize($this->customer, ['email' => 'mask']);

    expect($changed)->toBe([]);
});

it('maps list-style repeater fields onto the anonymize map', function () {
    $policy = RetentionPolicy::factory()->create([
        'model_class' => Customer::class,
        'anonymize_fields' => [
            ['field' => 'name', 'strategy' => 'mask'],
            ['field' => 'phone', 'strategy' => 'null'],
        ],
        'anonymize_values' => [
            ['field' => 'phone', 'value' => 'X'],
        ],
    ]);

    expect($policy->anonymizeFieldsMap())->toBe(['name' => 'mask', 'phone' => 'null'])
        ->and($policy->anonymizeValuesMap())->toBe(['phone' => 'X'])
        ->and($policy->action)->toBe(RetentionAction::Anonymize)
        ->and($policy->cutoff()->isPast())->toBeTrue();
});
