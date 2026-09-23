<?php

namespace ElvinQulizade\Gdpr;

use ElvinQulizade\Gdpr\Filament\Pages\DataSubjectRequest;
use ElvinQulizade\Gdpr\Filament\Pages\PrivacyRuns;
use ElvinQulizade\Gdpr\Filament\Resources\RetentionPolicyResource;
use ElvinQulizade\Gdpr\Filament\Widgets\DataPrivacyStatsWidget;
use Filament\Contracts\Plugin;
use Filament\Panel;

class GdprPlugin implements Plugin
{
    protected bool $registerNavigation = true;

    protected string | \Closure | null $navigationGroup = null;

    protected bool $statisticsWidget = true;

    public function getId(): string
    {
        return 'filament-gdpr';
    }

    public function register(Panel $panel): void
    {
        if (! $this->registerNavigation) {
            return;
        }

        $panel
            ->resources([RetentionPolicyResource::class])
            ->pages([PrivacyRuns::class, DataSubjectRequest::class]);

        if ($this->statisticsWidget) {
            $panel->widgets([DataPrivacyStatsWidget::class]);
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public function navigationGroup(string | \Closure | null $group): static
    {
        $this->navigationGroup = $group;

        return $this;
    }

    public function statisticsWidget(bool $enabled = true): static
    {
        $this->statisticsWidget = $enabled;

        return $this;
    }

    public function registerNavigation(bool $register = true): static
    {
        $this->registerNavigation = $register;

        return $this;
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament()->getPlugin(static::class);

        return $plugin;
    }
}
