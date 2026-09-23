<?php

// translations for ElvinQulizade/Gdpr
return [

    'plugin' => [
        'name' => 'Privacy',
        'navigation_group' => 'GDPR',
    ],

    'policy' => [
        'label' => 'Retention Policy',
        'plural_label' => 'Retention Policies',
        'navigation_label' => 'Retention',
    ],

    'runs' => [
        'title' => 'Privacy Runs',
        'navigation_label' => 'Privacy Runs',
        'empty' => 'No run logs yet.',
        'retry' => 'Retry policy',
        'retry_failed' => 'Retry failed policies',
        'success' => 'Policy executed successfully.',
    ],

    'dsar' => [
        'title' => 'Data Subject Request',
        'navigation_label' => 'Data Subject',
        'email' => 'Data subject email',
        'submit' => 'Generate export',
        'generating' => 'Generating export…',
        'success' => 'Personal data export has been generated.',
        'invalid_association' => 'Unable to protect data.',
        'export_your_data' => 'Export your data',
        'exported' => 'Personal data exported',
    ],

    'anonymization' => [
        'static_placeholder' => 'Redacted',
    ],

    'widgets' => [
        'enabled_policies' => 'Enabled policies',
        'total_deleted' => 'Records deleted',
        'total_anonymized' => 'Records anonymized',
        'exports' => 'Data exports',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Anonymize',
            'delete' => 'Delete',
        ],
        'period_units' => [
            'days' => 'days',
            'months' => 'months',
            'years' => 'years',
        ],
        'strategies' => [
            'null' => 'Set to null',
            'random' => 'Random value',
            'mask' => 'Mask',
            'static' => 'Static value',
        ],
        'run_statuses' => [
            'running' => 'Running',
            'succeeded' => 'Succeeded',
            'failed' => 'Failed',
        ],
        'export_statuses' => [
            'processing' => 'Processing',
            'completed' => 'Completed',
            'failed' => 'Failed',
        ],
    ],

    'fields' => [
        'name' => 'Name',
        'model_class' => 'Target model',
        'retention_column' => 'Retention column',
        'retention_period' => 'Retention period',
        'period_unit' => 'Period unit',
        'action' => 'Action',
        'anonymize_fields' => 'Fields to anonymize',
        'anonymize_values' => 'Static values',
        'enabled' => 'Enabled',
        'records_processed' => 'Processed',
        'records_deleted' => 'Deleted',
        'records_anonymized' => 'Anonymized',
        'status' => 'Status',
        'started_at' => 'Started at',
        'finished_at' => 'Finished at',
        'error' => 'Error',
        'data_subject' => 'Data subject',
        'path' => 'Path',
        'size' => 'Size',
        'created_at' => 'Created at',
        'policy' => 'Policy',
    ],

];
