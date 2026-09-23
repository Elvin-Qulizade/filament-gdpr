<?php

namespace ElvinQulizade\Gdpr\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use ElvinQulizade\Gdpr\GdprPlugin;
use ElvinQulizade\Gdpr\GdprServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Panel;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;

class TestCase extends Orchestra
{
    use LazilyRefreshDatabase;
    use WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'ElvinQulizade\\Gdpr\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        $providers = [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SchemasServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            GdprServiceProvider::class,
        ];

        sort($providers);

        return $providers;
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('app.key', 'base64:' . base64_encode(str_repeat('x', 32)));
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Fixtures/migrations');

        $tempMigrationsDir = sys_get_temp_dir() . '/gdpr-test-migrations';

        if (! is_file($tempMigrationsDir . '/create_filament_gdpr_tables.php')) {
            if (! is_dir($tempMigrationsDir)) {
                mkdir($tempMigrationsDir, 0777, true);
            }

            foreach (glob(__DIR__ . '/../database/migrations/*.php.stub') ?: [] as $stub) {
                copy($stub, $tempMigrationsDir . '/' . basename($stub, '.stub'));
            }
        }

        $this->loadMigrationsFrom($tempMigrationsDir);
    }

    protected function panel(): Panel
    {
        return Panel::make()
            ->id('admin')
            ->path('admin')
            ->default()
            ->plugins([GdprPlugin::make()]);
    }
}
