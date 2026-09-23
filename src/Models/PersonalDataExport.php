<?php

namespace ElvinQulizade\Gdpr\Models;

use ElvinQulizade\Gdpr\Database\Factories\PersonalDataExportFactory;
use ElvinQulizade\Gdpr\Enums\ExportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int|null $id
 * @property string $data_subject
 * @property ExportStatus $status
 * @property string|null $disk
 * @property string|null $path
 * @property int|null $size
 * @property string|null $error
 * @property Carbon|null $completed_at
 * @property Carbon $created_at
 */
class PersonalDataExport extends Model
{
    /** @use HasFactory<PersonalDataExportFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $table = 'filament_gdpr_exports';

    protected function casts(): array
    {
        return [
            'size' => 'integer',
            'status' => ExportStatus::class,
            'completed_at' => 'datetime',
        ];
    }

    protected static function newFactory(): PersonalDataExportFactory
    {
        return PersonalDataExportFactory::new();
    }
}
