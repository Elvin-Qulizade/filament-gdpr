<?php

namespace ElvinQulizade\Gdpr\Enums;

enum PrivacyRunStatus: string
{
    case Running = 'running';
    case Succeeded = 'succeeded';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Running => __('filament-gdpr::gdpr.enums.run_statuses.running'),
            self::Succeeded => __('filament-gdpr::gdpr.enums.run_statuses.succeeded'),
            self::Failed => __('filament-gdpr::gdpr.enums.run_statuses.failed'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Running => 'warning',
            self::Succeeded => 'success',
            self::Failed => 'danger',
        };
    }
}
