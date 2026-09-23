<?php

namespace ElvinQulizade\Gdpr\Enums;

enum ExportStatus: string
{
    case Processing = 'processing';
    case Completed = 'completed';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Processing => __('filament-gdpr::gdpr.enums.export_statuses.processing'),
            self::Completed => __('filament-gdpr::gdpr.enums.export_statuses.completed'),
            self::Failed => __('filament-gdpr::gdpr.enums.export_statuses.failed'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Processing => 'warning',
            self::Completed => 'success',
            self::Failed => 'danger',
        };
    }
}
