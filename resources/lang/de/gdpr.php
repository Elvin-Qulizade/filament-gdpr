<?php

// translations for ElvinQulizade/Gdpr — German
return [

    'plugin' => [
        'name' => 'Datenschutz',
        'navigation_group' => 'DSGVO',
    ],

    'policy' => [
        'label' => 'Aufbewahrungsrichtlinie',
        'plural_label' => 'Aufbewahrungsrichtlinien',
        'navigation_label' => 'Aufbewahrung',
    ],

    'runs' => [
        'title' => 'Datenschutz-Läufe',
        'navigation_label' => 'Datenschutz-Läufe',
        'empty' => 'Noch keine Laufprotokolle.',
        'retry' => 'Richtlinie erneut ausführen',
        'retry_failed' => 'Fehlgeschlagene Richtlinien erneut ausführen',
        'success' => 'Richtlinie erfolgreich ausgeführt.',
    ],

    'dsar' => [
        'title' => 'Antrag betroffener Personen',
        'navigation_label' => 'Betroffene Person',
        'email' => 'E-Mail der betroffenen Person',
        'submit' => 'Export erstellen',
        'generating' => 'Export wird erstellt…',
        'success' => 'Export personenbezogener Daten wurde erstellt.',
        'invalid_association' => 'Daten können nicht geschützt werden.',
        'export_your_data' => 'Daten exportieren',
        'exported' => 'Personenbezogene Daten exportiert',
    ],

    'anonymization' => [
        'static_placeholder' => 'Geschwärzt',
    ],

    'widgets' => [
        'enabled_policies' => 'Aktive Richtlinien',
        'total_deleted' => 'Gelöschte Datensätze',
        'total_anonymized' => 'Anonymisierte Datensätze',
        'exports' => 'Datenexporte',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Anonymisieren',
            'delete' => 'Löschen',
        ],
        'period_units' => [
            'days' => 'Tage',
            'months' => 'Monate',
            'years' => 'Jahre',
        ],
        'strategies' => [
            'null' => 'Auf null setzen',
            'random' => 'Zufälliger Wert',
            'mask' => 'Maskieren',
            'static' => 'Statischer Wert',
        ],
        'run_statuses' => [
            'running' => 'Läuft',
            'succeeded' => 'Erfolgreich',
            'failed' => 'Fehlgeschlagen',
        ],
        'export_statuses' => [
            'processing' => 'Wird verarbeitet',
            'completed' => 'Abgeschlossen',
            'failed' => 'Fehlgeschlagen',
        ],
    ],

    'fields' => [
        'name' => 'Name',
        'model_class' => 'Zielmodell',
        'retention_column' => 'Aufbewahrungsspalte',
        'retention_period' => 'Aufbewahrungsdauer',
        'period_unit' => 'Zeiteinheit',
        'action' => 'Aktion',
        'anonymize_fields' => 'Zu anonymisierende Felder',
        'anonymize_values' => 'Statische Werte',
        'enabled' => 'Aktiviert',
        'records_processed' => 'Verarbeitet',
        'records_deleted' => 'Gelöscht',
        'records_anonymized' => 'Anonymisiert',
        'status' => 'Status',
        'started_at' => 'Gestartet um',
        'finished_at' => 'Beendet um',
        'error' => 'Fehler',
        'data_subject' => 'Betroffene Person',
        'path' => 'Pfad',
        'size' => 'Größe',
        'created_at' => 'Erstellt am',
        'policy' => 'Richtlinie',
    ],

];
