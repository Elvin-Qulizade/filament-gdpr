<?php

namespace ElvinQulizade\Gdpr\Enums;

enum RetentionPeriodUnit: string
{
    case Days = 'days';
    case Months = 'months';
    case Years = 'years';

    public function label(): string
    {
        return match ($this) {
            self::Days => __('filament-gdpr::gdpr.enums.period_units.days'),
            self::Months => __('filament-gdpr::gdpr.enums.period_units.months'),
            self::Years => __('filament-gdpr::gdpr.enums.period_units.years'),
        };
    }
}
