<?php

// translations for ElvinQulizade/Gdpr — Turkish
return [

    'plugin' => [
        'name' => 'Gizlilik',
        'navigation_group' => 'KVKK',
    ],

    'policy' => [
        'label' => 'Saklama politikası',
        'plural_label' => 'Saklama politikaları',
        'navigation_label' => 'Saklama',
    ],

    'runs' => [
        'title' => 'Gizlilik çalıştırmaları',
        'navigation_label' => 'Gizlilik çalıştırmaları',
        'empty' => 'Henüz çalıştırma kaydı yok.',
        'retry' => 'Politikayı yeniden çalıştır',
        'retry_failed' => 'Başarısız politikaları yeniden çalıştır',
        'success' => 'Politika başarıyla çalıştırıldı.',
    ],

    'dsar' => [
        'title' => 'Veri sahibi talebi',
        'navigation_label' => 'Veri sahibi',
        'email' => 'Veri sahibi e-postası',
        'submit' => 'Dışa aktarım oluştur',
        'generating' => 'Dışa aktarım oluşturuluyor…',
        'success' => 'Kişisel veri dışa aktarımı oluşturuldu.',
        'invalid_association' => 'Veriler korunamadı.',
        'export_your_data' => 'Verilerinizi dışa aktarın',
        'exported' => 'Kişisel veriler dışa aktarıldı',
    ],

    'anonymization' => [
        'static_placeholder' => 'Redakte edildi',
    ],

    'widgets' => [
        'enabled_policies' => 'Etkin politikalar',
        'total_deleted' => 'Silinen kayıtlar',
        'total_anonymized' => 'Anonimleştirilen kayıtlar',
        'exports' => 'Veri dışa aktarımları',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Anonimleştir',
            'delete' => 'Sil',
        ],
        'period_units' => [
            'days' => 'gün',
            'months' => 'ay',
            'years' => 'yıl',
        ],
        'strategies' => [
            'null' => 'Null yap',
            'random' => 'Rastgele değer',
            'mask' => 'Maskele',
            'static' => 'Statik değer',
        ],
        'run_statuses' => [
            'running' => 'Çalışıyor',
            'succeeded' => 'Başarılı',
            'failed' => 'Başarısız',
        ],
        'export_statuses' => [
            'processing' => 'İşleniyor',
            'completed' => 'Tamamlandı',
            'failed' => 'Başarısız',
        ],
    ],

    'fields' => [
        'name' => 'Ad',
        'model_class' => 'Hedef model',
        'retention_column' => 'Saklama sütunu',
        'retention_period' => 'Saklama süresi',
        'period_unit' => 'Süre birimi',
        'action' => 'İşlem',
        'anonymize_fields' => 'Anonimleştirilecek alanlar',
        'anonymize_values' => 'Statik değerler',
        'enabled' => 'Etkin',
        'records_processed' => 'İşlendi',
        'records_deleted' => 'Silindi',
        'records_anonymized' => 'Anonimleştirildi',
        'status' => 'Durum',
        'started_at' => 'Başlangıç',
        'finished_at' => 'Bitiş',
        'error' => 'Hata',
        'data_subject' => 'Veri sahibi',
        'path' => 'Yol',
        'size' => 'Boyut',
        'created_at' => 'Oluşturma tarihi',
        'policy' => 'Politika',
    ],

];
