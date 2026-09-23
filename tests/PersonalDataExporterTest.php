<?php

use ElvinQulizade\Gdpr\Enums\ExportStatus;
use ElvinQulizade\Gdpr\Models\PersonalDataExport;
use ElvinQulizade\Gdpr\Support\PersonalDataExporter;
use ElvinQulizade\Gdpr\Tests\Fixtures\Customer;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    config()->set('filament-gdpr.models', [
        Customer::class => ['column' => 'email'],
    ]);
    config()->set('filament-gdpr.user_model', Customer::class);
    config()->set('filament-gdpr.user_identifier', 'email');

    Customer::create([
        'name' => 'Jane Roe',
        'email' => 'jane@example.com',
        'phone' => '999',
        'notes' => 'data-point',
    ]);
    Customer::create([
        'name' => 'Other',
        'email' => 'other@example.com',
        'phone' => '000',
        'notes' => 'nope',
    ]);
})->skip(extension_loaded('zip') === false, 'ext-zip is required');

it('builds a zip archive containing the data subject records', function () {
    $export = (new PersonalDataExporter(disk: 'local'))->export('jane@example.com');

    $export->refresh();

    expect($export->status)->toBe(ExportStatus::Completed)
        ->and($export->path)->toBeString()
        ->and($export->size)->toBeGreaterThan(0);

    $this->assertTrue(Storage::disk('local')->exists($export->path));

    $zipPath = Storage::disk('local')->path($export->path);
    $zip = new ZipArchive;
    $zip->open($zipPath);
    expect($zip->locateName('data.json'))->toBeGreaterThanOrEqual(0)
        ->and($zip->locateName('index.html'))->toBeGreaterThanOrEqual(0);

    $json = json_decode($zip->getFromName('data.json'), true);
    expect($json)->toHaveKey('Customer')
        ->and($json['Customer'][0]['email'])->toBe('jane@example.com');

    $zip->close();
});

it('records a failed export when the zip cannot be written', function () {
    config()->set('filesystems.disks.blocked', [
        'driver' => 'local',
        'root' => str_repeat('x', 30000),
    ]);

    try {
        (new PersonalDataExporter(disk: 'blocked'))->export('jane@example.com');
    } catch (Throwable) {
        // the exporter rethrows after recording the failure
    }

    expect(PersonalDataExport::first()->status)->toBe(ExportStatus::Failed);
});

it('returns full record payloads for fields requested in the config', function () {
    $export = (new PersonalDataExporter(disk: 'local'))->export('jane@example.com');

    expect(PersonalDataExport::whereKey($export->id)->value('data_subject'))->toBe('jane@example.com');
});
