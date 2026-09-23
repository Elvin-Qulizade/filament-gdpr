<?php

// translations for ElvinQulizade/Gdpr — Azerbaijani
return [

    'plugin' => [
        'name' => 'Məxfilik',
        'navigation_group' => 'GDPR',
    ],

    'policy' => [
        'label' => 'Saxlama siyasəti',
        'plural_label' => 'Saxlama siyasətləri',
        'navigation_label' => 'Saxlama',
    ],

    'runs' => [
        'title' => 'Məxfilik icraları',
        'navigation_label' => 'Məxfilik icraları',
        'empty' => 'Hələ icra qeydi yoxdur.',
        'retry' => 'Siyasəti yenidən işlət',
        'retry_failed' => 'Uğursuz siyasətləri yenilə',
        'success' => 'Siyasət uğurla icra olundu.',
    ],

    'dsar' => [
        'title' => 'Məlumat subyekti sorğusu',
        'navigation_label' => 'Məlumat subyekti',
        'email' => 'Məlumat subyektinin e-poçtu',
        'submit' => 'İxrac yarat',
        'generating' => 'İxrac hazırlanır…',
        'success' => 'Şəxsi məlumat ixracı yaradıldı.',
        'invalid_association' => 'Məlumatları qorumaq mümkün olmadı.',
        'export_your_data' => 'Məlumatlarınızı ixrac edin',
        'exported' => 'Şəxsi məlumat ixrac edildi',
    ],

    'anonymization' => [
        'static_placeholder' => 'Redaktə olunub',
    ],

    'widgets' => [
        'enabled_policies' => 'Aktiv siyasətlər',
        'total_deleted' => 'Silinmiş qeydlər',
        'total_anonymized' => 'Anonimləşdirilmiş qeydlər',
        'exports' => 'Məlumat ixracları',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Anonimləşdir',
            'delete' => 'Sil',
        ],
        'period_units' => [
            'days' => 'gün',
            'months' => 'ay',
            'years' => 'il',
        ],
        'strategies' => [
            'null' => 'Null təyin et',
            'random' => 'Təsadüfi qiymət',
            'mask' => 'Maskalama',
            'static' => 'Statik qiymət',
        ],
        'run_statuses' => [
            'running' => 'İcra olunur',
            'succeeded' => 'Uğurlu',
            'failed' => 'Uğursuz',
        ],
        'export_statuses' => [
            'processing' => 'Hazırlanır',
            'completed' => 'Tamamlandı',
            'failed' => 'Uğursuz',
        ],
    ],

    'fields' => [
        'name' => 'Ad',
        'model_class' => 'Hədəf model',
        'retention_column' => 'Saxlama sütunu',
        'retention_period' => 'Saxlama müddəti',
        'period_unit' => 'Müddət vahidi',
        'action' => 'Əməliyyat',
        'anonymize_fields' => 'Anonimləşdiriləcək sahələr',
        'anonymize_values' => 'Statik qiymətlər',
        'enabled' => 'Aktiv',
        'records_processed' => 'Emal olundu',
        'records_deleted' => 'Silindi',
        'records_anonymized' => 'Anonimləşdirildi',
        'status' => 'Status',
        'started_at' => 'Başlanma vaxtı',
        'finished_at' => 'Bitmə vaxtı',
        'error' => 'Xəta',
        'data_subject' => 'Məlumat subyekti',
        'path' => 'Yol',
        'size' => 'Ölçü',
        'created_at' => 'Yaradılma tarixi',
        'policy' => 'Siyasət',
    ],

];
