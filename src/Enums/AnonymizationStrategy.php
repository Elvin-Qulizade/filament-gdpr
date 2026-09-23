<?php

namespace ElvinQulizade\Gdpr\Enums;

enum AnonymizationStrategy: string
{
    case Null = 'null';
    case Random = 'random';
    case Mask = 'mask';
    case Static = 'static';

    public function label(): string
    {
        return match ($this) {
            self::Null => __('filament-gdpr::gdpr.enums.strategies.null'),
            self::Random => __('filament-gdpr::gdpr.enums.strategies.random'),
            self::Mask => __('filament-gdpr::gdpr.enums.strategies.mask'),
            self::Static => __('filament-gdpr::gdpr.enums.strategies.static'),
        };
    }
}
