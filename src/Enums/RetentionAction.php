<?php

namespace ElvinQulizade\Gdpr\Enums;

enum RetentionAction: string
{
    case Anonymize = 'anonymize';
    case Delete = 'delete';

    public function label(): string
    {
        return match ($this) {
            self::Anonymize => __('filament-gdpr::gdpr.enums.retention_actions.anonymize'),
            self::Delete => __('filament-gdpr::gdpr.enums.retention_actions.delete'),
        };
    }
}
