<?php

namespace ElvinQulizade\Gdpr\Support;

use ElvinQulizade\Gdpr\Enums\PrivacyRunStatus;
use ElvinQulizade\Gdpr\Models\PersonalDataExport;
use ElvinQulizade\Gdpr\Models\PrivacyRunLog;
use ElvinQulizade\Gdpr\Models\RetentionPolicy;
use Illuminate\Support\Carbon;

class Statistics
{
    public function enabledPolicies(): int
    {
        return RetentionPolicy::query()->where('enabled', true)->count();
    }

    public function totalDeleted(): int
    {
        return (int) PrivacyRunLog::query()
            ->where('status', PrivacyRunStatus::Succeeded)
            ->sum('records_deleted');
    }

    public function totalAnonymized(): int
    {
        return (int) PrivacyRunLog::query()
            ->where('status', PrivacyRunStatus::Succeeded)
            ->sum('records_anonymized');
    }

    public function totalExports(): int
    {
        return PersonalDataExport::query()->count();
    }

    public function lastRunAt(): ?Carbon
    {
        return PrivacyRunLog::query()->max('finished_at');
    }
}
