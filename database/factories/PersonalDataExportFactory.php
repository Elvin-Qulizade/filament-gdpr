<?php

namespace ElvinQulizade\Gdpr\Database\Factories;

use ElvinQulizade\Gdpr\Enums\ExportStatus;
use ElvinQulizade\Gdpr\Models\PersonalDataExport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PersonalDataExport>
 */
class PersonalDataExportFactory extends Factory
{
    protected $model = PersonalDataExport::class;

    public function definition(): array
    {
        return [
            'data_subject' => fake()->safeEmail(),
            'status' => ExportStatus::Completed,
            'disk' => 'local',
            'path' => 'filament-gdpr-exports/1/1.zip',
            'size' => 1024,
            'completed_at' => now(),
        ];
    }
}
