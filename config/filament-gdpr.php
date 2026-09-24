<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User model
    |--------------------------------------------------------------------------
    |
    | The model used to identify data subjects for personal data exports.
    |
    */

    'user_model' => env('GDPR_USER_MODEL', 'App\Models\User'),

    /*
    |--------------------------------------------------------------------------
    | User identifier
    |--------------------------------------------------------------------------
    |
    | The column that uniquely identifies a data subject (used by the exporter
    | to match records across the configured models).
    |
    */

    'user_identifier' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Export storage
    |--------------------------------------------------------------------------
    |
    | Filesystem disk and directory prefix used for generated personal data
    | export archives.
    |
    */

    'disk' => env('GDPR_EXPORT_DISK', 'local'),

    'export_prefix' => 'filament-gdpr-exports',

    /*
    |--------------------------------------------------------------------------
    | Deletion behaviour
    |--------------------------------------------------------------------------
    |
    | When a policy uses the "delete" action, decide whether soft-deletable
    | models keep a soft delete (trash) row or are force-deleted.
    |
    | Supported values: 'soft', 'force'
    |
    */

    'delete_mode' => env('GDPR_DELETE_MODE', 'force'),

    /*
    |--------------------------------------------------------------------------
    | Anonymization
    |--------------------------------------------------------------------------
    |
    | allow_unique_overwrite: allow anonymizing columns covered by a unique
    | index (temporarily disabled for safety reasons).
    |
    */

    'allow_unique_overwrite' => false,

    'default_strategy' => 'mask',

    /*
    |--------------------------------------------------------------------------
    | Models to export
    |--------------------------------------------------------------------------
    |
    | Map each model to the column that holds the data subject identifier.
    | The user_model is included automatically.
    |
    | 'App\Models\Order' => 'email',
    | 'App\Models\Profile' => 'user_email',
    |
    */

    'models' => [],

    /*
    |--------------------------------------------------------------------------
    | Model discovery
    |--------------------------------------------------------------------------
    |
    | Paths scanned to offer model selection in the policy form, plus class
    | names to exclude from that list.
    |
    */

    'model_discovery' => [
        'exclude' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament navigation
    |--------------------------------------------------------------------------
    */

    'navigation_group' => env('GDPR_NAVIGATION_GROUP', null),

    /*
    |--------------------------------------------------------------------------
    | Scheduling
    |--------------------------------------------------------------------------
    |
    | Enable automatic retention runs via Laravel's scheduler.
    | Supported frequencies: everyMinute, hourly, daily, weekly, monthly.
    |
    */

    'schedule' => [
        'enabled' => env('GDPR_SCHEDULE_ENABLED', false),
        'frequency' => env('GDPR_SCHEDULE_FREQUENCY', 'daily'),
    ],

];
