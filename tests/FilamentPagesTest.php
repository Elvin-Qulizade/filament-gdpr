<?php

use ElvinQulizade\Gdpr\Filament\Pages\DataSubjectRequest;
use ElvinQulizade\Gdpr\Filament\Pages\PrivacyRuns;
use ElvinQulizade\Gdpr\Filament\Resources\RetentionPolicyResource;
use ElvinQulizade\Gdpr\Filament\Widgets\DataPrivacyStatsWidget;
use ElvinQulizade\Gdpr\GdprPlugin;
use ElvinQulizade\Gdpr\Models\RetentionPolicy;
use Filament\Facades\Filament;
use Filament\Panel;
use Livewire\Livewire;

it('registers its resource, pages and widget on the panel', function () {
    $panel = Panel::make()
        ->id('admin')
        ->path('admin')
        ->default()
        ->plugins([GdprPlugin::make()]);

    expect($panel->getResources())->toContain(RetentionPolicyResource::class)
        ->and($panel->getPages())->toContain(PrivacyRuns::class)
        ->and($panel->getPages())->toContain(DataSubjectRequest::class)
        ->and($panel->getWidgets())->toContain(DataPrivacyStatsWidget::class);
});

it('maps the retention policy model', function () {
    expect(RetentionPolicyResource::getModel())->toBe(RetentionPolicy::class);
});

it('registers index, create and edit routes for the resource', function () {
    $pages = RetentionPolicyResource::getPages();

    expect(array_keys($pages))->toBe(['index', 'create', 'edit'])
        ->and(RetentionPolicyResource::getModelLabel())->toBe(__('filament-gdpr::gdpr.policy.label'));
});

it('renders the privacy runs page', function () {
    Filament::setCurrentPanel($this->panel());

    Livewire::test(PrivacyRuns::class)
        ->assertSuccessful();
});

it('renders the data subject request page', function () {
    Filament::setCurrentPanel($this->panel());

    Livewire::test(DataSubjectRequest::class)
        ->set('dataSubject', 'jane@example.com')
        ->assertSuccessful();
});
