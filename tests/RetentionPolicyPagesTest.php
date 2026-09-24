<?php

use ElvinQulizade\Gdpr\Filament\Resources\RetentionPolicyResource;
use ElvinQulizade\Gdpr\Filament\Resources\RetentionPolicyResource\Pages\CreateRetentionPolicy;
use ElvinQulizade\Gdpr\Filament\Resources\RetentionPolicyResource\Pages\EditRetentionPolicy;
use ElvinQulizade\Gdpr\Models\RetentionPolicy;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

function registerResourceRoutes(): void
{
    $panel = Filament::getCurrentPanel();

    Route::middleware([])
        ->prefix($panel->getPath())
        ->name('filament.' . $panel->getId() . '.')
        ->group(fn () => RetentionPolicyResource::registerRoutes($panel));
}

it('renders the create retention policy page', function () {
    Filament::setCurrentPanel($this->panel());
    registerResourceRoutes();

    Livewire::test(CreateRetentionPolicy::class)
        ->assertSuccessful()
        ->assertFormFieldExists('name')
        ->assertFormFieldExists('model_class')
        ->assertFormFieldExists('retention_period');
});

it('renders the edit retention policy page', function () {
    Filament::setCurrentPanel($this->panel());
    registerResourceRoutes();

    $policy = RetentionPolicy::factory()->create();

    Livewire::test(EditRetentionPolicy::class, ['record' => $policy->getKey()])
        ->assertSuccessful();
});
