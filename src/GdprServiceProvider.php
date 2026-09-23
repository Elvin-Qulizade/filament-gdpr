<?php

namespace ElvinQulizade\Gdpr;

use ElvinQulizade\Gdpr\Commands\PrivacyExportCommand;
use ElvinQulizade\Gdpr\Commands\PrivacyRunCommand;
use ElvinQulizade\Gdpr\Support\Anonymizer;
use ElvinQulizade\Gdpr\Support\PersonalDataExporter;
use ElvinQulizade\Gdpr\Support\RetentionRunner;
use ElvinQulizade\Gdpr\Testing\TestsGdpr;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GdprServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-gdpr';

    public static string $viewNamespace = 'filament-gdpr';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('elvinqulizade/filament-gdpr');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
        $this->app->scoped(Gdpr::class, function ($app) {
            return new Gdpr(
                runner: $app->make(RetentionRunner::class),
                exporter: $app->make(PersonalDataExporter::class),
                anonymizer: $app->make(Anonymizer::class),
            );
        });

        $this->app->scoped(RetentionRunner::class, function ($app) {
            return new RetentionRunner($app->make(Anonymizer::class));
        });

        $this->app->scoped(PersonalDataExporter::class, fn () => new PersonalDataExporter(config('filament-gdpr.disk') ?? 'local'));
    }

    public function packageBooted(): void
    {
        $this->registerScheduledRun();

        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-gdpr/{$file->getFilename()}"),
                ], 'filament-gdpr-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsGdpr);
    }

    protected function registerScheduledRun(): void
    {
        if (! config('filament-gdpr.schedule.enabled')) {
            return;
        }

        $this->app->booted(function () {
            $frequency = config('filament-gdpr.schedule.frequency', 'daily');
            $supported = ['everyMinute', 'hourly', 'daily', 'weekly', 'monthly', 'everyTwoHours', 'everySixHours'];

            if (! in_array($frequency, $supported, true) || ! method_exists(Schedule::class, $frequency)) {
                $frequency = 'daily';
            }

            $this->app->make(Schedule::class)
                ->command(PrivacyRunCommand::class)
                ->{$frequency}();
        });
    }

    protected function getAssetPackageName(): ?string
    {
        return 'elvinqulizade/filament-gdpr';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-gdpr', __DIR__ . '/../resources/dist/components/filament-gdpr.js'),
            // Css::make('filament-gdpr-styles', __DIR__ . '/../resources/dist/filament-gdpr.css'),
            // Js::make('filament-gdpr-scripts', __DIR__ . '/../resources/dist/filament-gdpr.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            PrivacyRunCommand::class,
            PrivacyExportCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_filament_gdpr_tables',
        ];
    }
}
