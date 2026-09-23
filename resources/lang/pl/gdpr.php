<?php

// translations for ElvinQulizade/Gdpr — Polish
return [

    'plugin' => [
        'name' => 'Prywatność',
        'navigation_group' => 'RODO',
    ],

    'policy' => [
        'label' => 'Polityka przechowywania',
        'plural_label' => 'Polityki przechowywania',
        'navigation_label' => 'Przechowywanie',
    ],

    'runs' => [
        'title' => 'Uruchomienia prywatności',
        'navigation_label' => 'Uruchomienia prywatności',
        'empty' => 'Brak jeszcze dzienników uruchomień.',
        'retry' => 'Ponów politykę',
        'retry_failed' => 'Ponów nieudane polityki',
        'success' => 'Polityka wykonana pomyślnie.',
    ],

    'dsar' => [
        'title' => 'Żądanie podmiotu danych',
        'navigation_label' => 'Podmiot danych',
        'email' => 'E-mail podmiotu danych',
        'submit' => 'Generuj eksport',
        'generating' => 'Generowanie eksportu…',
        'success' => 'Wygenerowano eksport danych osobowych.',
        'invalid_association' => 'Nie udało się chronić danych.',
        'export_your_data' => 'Wyeksportuj swoje dane',
        'exported' => 'Dane osobowe wyeksportowane',
    ],

    'anonymization' => [
        'static_placeholder' => 'Zredagowano',
    ],

    'widgets' => [
        'enabled_policies' => 'Aktywne polityki',
        'total_deleted' => 'Usunięte rekordy',
        'total_anonymized' => 'Zanonimizowane rekordy',
        'exports' => 'Eksporty danych',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Anonimizuj',
            'delete' => 'Usuń',
        ],
        'period_units' => [
            'days' => 'dni',
            'months' => 'miesięcy',
            'years' => 'lat',
        ],
        'strategies' => [
            'null' => 'Ustaw na null',
            'random' => 'Losowa wartość',
            'mask' => 'Maskuj',
            'static' => 'Wartość statyczna',
        ],
        'run_statuses' => [
            'running' => 'W trakcie',
            'succeeded' => 'Powodzenie',
            'failed' => 'Niepowodzenie',
        ],
        'export_statuses' => [
            'processing' => 'Przetwarzanie',
            'completed' => 'Zakończono',
            'failed' => 'Niepowodzenie',
        ],
    ],

    'fields' => [
        'name' => 'Nazwa',
        'model_class' => 'Model docelowy',
        'retention_column' => 'Kolumna przechowywania',
        'retention_period' => 'Okres przechowywania',
        'period_unit' => 'Jednostka okresu',
        'action' => 'Akcja',
        'anonymize_fields' => 'Pola do anonimizacji',
        'anonymize_values' => 'Wartości statyczne',
        'enabled' => 'Włączona',
        'records_processed' => 'Przetworzono',
        'records_deleted' => 'Usunięto',
        'records_anonymized' => 'Zanonimizowano',
        'status' => 'Status',
        'started_at' => 'Rozpoczęto o',
        'finished_at' => 'Zakończono o',
        'error' => 'Błąd',
        'data_subject' => 'Podmiot danych',
        'path' => 'Ścieżka',
        'size' => 'Rozmiar',
        'created_at' => 'Utworzono',
        'policy' => 'Polityka',
    ],

];
