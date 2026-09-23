<?php

namespace ElvinQulizade\Gdpr\Models;

use ElvinQulizade\Gdpr\Database\Factories\PrivacyRunLogFactory;
use ElvinQulizade\Gdpr\Enums\PrivacyRunStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int|null $id
 * @property int|null $retention_policy_id
 * @property PrivacyRunStatus $status
 * @property int $records_processed
 * @property int $records_deleted
 * @property int $records_anonymized
 * @property Carbon|null $started_at
 * @property Carbon|null $finished_at
 * @property string|null $error
 * @property RetentionPolicy|null $policy
 */
class PrivacyRunLog extends Model
{
    /** @use HasFactory<PrivacyRunLogFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $table = 'filament_gdpr_run_logs';

    protected function casts(): array
    {
        return [
            'records_processed' => 'integer',
            'records_deleted' => 'integer',
            'records_anonymized' => 'integer',
            'status' => PrivacyRunStatus::class,
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    protected static function newFactory(): PrivacyRunLogFactory
    {
        return PrivacyRunLogFactory::new();
    }

    /**
     * @return BelongsTo<RetentionPolicy, $this>
     */
    public function policy(): BelongsTo
    {
        return $this->belongsTo(RetentionPolicy::class, 'retention_policy_id');
    }
}
