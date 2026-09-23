# Filament GDPR

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elvinqulizade/filament-gdpr.svg?style=flat-square)](https://packagist.org/packages/elvinqulizade/filament-gdpr)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/elvinqulizade/filament-gdpr/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/elvinqulizade/filament-gdpr/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/elvinqulizade/filament-gdpr/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/elvinqulizade/filament-gdpr/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/elvinqulizade/filament-gdpr.svg?style=flat-square)](https://packagist.org/packages/elvinqulizade/filament-gdpr)

Data retention & personal data management for Filament v5.

Filament GDPR gives you a retention policy engine and data-subject tooling on top of Eloquent:

- **Retention policies** — per model, define a retention period and what happens when it expires (`delete` or `anonymize`).
- **Automatic privacy runs** — scheduled (or manual) sweeps that anonymize or delete records past their cutoff.
- **Run history** — a log of every privacy run with processed/deleted/anonymized counts.
- **Data subject exports** — generate a ZIP archive (JSON + readable HTML) of all a subject's records for DSAR responses.
- **A Filament panel** — manage policies, trigger runs, view stats, and export a subject's data from the UI.

## Installation

You can install the package via composer:

```bash
composer require elvinqulizade/filament-gdpr
```

> [!IMPORTANT]
> If you have not set up a custom theme and are using Filament Panels follow the instructions in the [Filament Docs](https://filamentphp.com/docs/5.x/styling/overview#creating-a-custom-theme) first.

After setting up a custom theme add the plugin's views to your theme css file or your app's css file if using the standalone packages.

```css
@source '../../../../vendor/elvinqulizade/filament-gdpr/resources/**/*.blade.php';
```

Publish and run the migrations:

```bash
php artisan vendor:publish --tag="filament-gdpr-migrations"
php artisan migrate
```

Publish the config file:

```bash
php artisan vendor:publish --tag="filament-gdpr-config"
```

This is the contents of the published config file:

```php
return [

    'user_model' => \App\Models\User::class,
    'user_identifier' => 'email',

    'disk' => 'local',
    'export_prefix' => 'gdpr-exports',

    'delete_mode' => 'soft', // soft | force

    'allow_unique_overwrite' => false,
    'default_strategy' => 'mask',

    'models' => [],

    'model_discovery' => [
        'exclude' => [],
    ],

    'navigation_group' => 'Privacy',

    'schedule' => [
        'enabled' => env('FILAMENT_GDPR_SCHEDULE', true),
        'frequency' => 'daily', // everyMinute | hourly | everyTwoHours | everySixHours | daily | weekly | monthly
    ],

];
```

## Registering the plugin

```php
use ElvinQulizade\Gdpr\GdprPlugin;

->plugins([
    GdprPlugin::make()
        ->navigationGroup('Privacy')
        ->statisticsWidget(true),
])
```

## Usage

### Retention policies

Retention policies are stored in the database and managed from the Filament panel
(`Privacy -> Retention policies`) or via the facade:

```php
use ElvinQulizade\Gdpr\Enums\RetentionAction;
use ElvinQulizade\Gdpr\Enums\RetentionPeriodUnit;
use ElvinQulizade\Gdpr\Models\RetentionPolicy;

RetentionPolicy::create([
    'name' => 'Order history',
    'model_class' => \App\Models\Order::class,
    'retention_column' => 'created_at',
    'retention_period' => 24,
    'period_unit' => RetentionPeriodUnit::Months,
    'action' => RetentionAction::Anonymize,
    'anonymize_fields' => ['customer_email' => 'email', 'customer_name' => 'mask'],
    'enabled' => true,
]);
```

### Running the privacy sweep

Manually, or via the scheduler:

```bash
php artisan privacy:run
php artisan privacy:run --policy=12 --dry-run
```

Scheduled runs are enabled by default (`config('filament-gdpr.schedule')`);

### Exporting a data subject's data

```bash
php artisan privacy:export user@example.com
```

Or from the Filament panel (`Privacy -> Data subject request`). Every export is stored in
`filament_gdpr_exports` and written to the configured disk.

### Using the facade

```php
use ElvinQulizade\Gdpr\Facades\Gdpr;

Gdpr::policies();                // enabled policies
Gdpr::run();                     // run the privacy sweep (respects dry-run config)
Gdpr::anonymize($model, []);     // anonymize a single model instance
Gdpr::exporter()->export('user@example.com'); // create an export for a subject
```

## How anonymization works

Configured columns are masked with the chosen strategy:

- `mask` — keeps the first 2 characters, masks the rest (`jo***`); emails keep their domain (`j***@example.com`).
- `static` — replaces the value with the static value configured on the policy.
- `null` — sets the column to `null`.

Primary keys, timestamps, and `password`-like columns are never touched. Columns covered by a
unique index are skipped unless `allow_unique_overwrite` is enabled.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Elvin-Qulizade](https://github.com/Elvin-Qulizade)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.