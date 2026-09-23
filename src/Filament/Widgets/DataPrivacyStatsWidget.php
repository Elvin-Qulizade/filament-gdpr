<?php

namespace ElvinQulizade\Gdpr\Filament\Widgets;

use ElvinQulizade\Gdpr\Support\Statistics;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DataPrivacyStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 0;

    /**
     * @return array<int, Stat>
     */
    protected function getStats(): array
    {
        $statistics = new Statistics;

        return [
            Stat::make(
                __('filament-gdpr::gdpr.widgets.enabled_policies'),
                $statistics->enabledPolicies(),
            )
                ->icon('heroicon-o-shield-check')
                ->color('success'),

            Stat::make(
                __('filament-gdpr::gdpr.widgets.total_deleted'),
                $statistics->totalDeleted(),
            )
                ->icon('heroicon-o-trash')
                ->color('danger'),

            Stat::make(
                __('filament-gdpr::gdpr.widgets.total_anonymized'),
                $statistics->totalAnonymized(),
            )
                ->icon('heroicon-o-eye-slash')
                ->color('info'),

            Stat::make(
                __('filament-gdpr::gdpr.widgets.exports'),
                $statistics->totalExports(),
            )
                ->icon('heroicon-o-document-arrow-down')
                ->color('primary'),
        ];
    }
}
