<?php

// translations for ElvinQulizade/Gdpr — Dutch
return [

    'plugin' => [
        'name' => 'Privacy',
        'navigation_group' => 'AVG',
    ],

    'policy' => [
        'label' => 'Bewaarbeleid',
        'plural_label' => 'Bewaarbeleidsregels',
        'navigation_label' => 'Bewaring',
    ],

    'runs' => [
        'title' => 'Privacyruns',
        'navigation_label' => 'Privacyruns',
        'empty' => 'Nog geen runlogboeken.',
        'retry' => 'Beleid opnieuw uitvoeren',
        'retry_failed' => 'Mislukte beleidsregels opnieuw uitvoeren',
        'success' => 'Beleid succesvol uitgevoerd.',
    ],

    'dsar' => [
        'title' => 'Verzoek van de betrokkene',
        'navigation_label' => 'Betrokkene',
        'email' => 'E-mail van de betrokkene',
        'submit' => 'Export genereren',
        'generating' => 'Export genereren…',
        'success' => 'De export van persoonsgegevens is gegenereerd.',
        'invalid_association' => 'Gegevens kunnen niet worden beschermd.',
        'export_your_data' => 'Exporteer uw gegevens',
        'exported' => 'Persoonsgegevens geëxporteerd',
    ],

    'anonymization' => [
        'static_placeholder' => 'Geredigeerd',
    ],

    'widgets' => [
        'enabled_policies' => 'Actieve beleidsregels',
        'total_deleted' => 'Verwijderde records',
        'total_anonymized' => 'Geanonimiseerde records',
        'exports' => 'Gegevensexports',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Anonimiseren',
            'delete' => 'Verwijderen',
        ],
        'period_units' => [
            'days' => 'dagen',
            'months' => 'maanden',
            'years' => 'jaren',
        ],
        'strategies' => [
            'null' => 'Instellen op null',
            'random' => 'Willekeurige waarde',
            'mask' => 'Maskeren',
            'static' => 'Statische waarde',
        ],
        'run_statuses' => [
            'running' => 'Bezig',
            'succeeded' => 'Geslaagd',
            'failed' => 'Mislukt',
        ],
        'export_statuses' => [
            'processing' => 'Verwerken',
            'completed' => 'Voltooid',
            'failed' => 'Mislukt',
        ],
    ],

    'fields' => [
        'name' => 'Naam',
        'model_class' => 'Doelmodel',
        'retention_column' => 'Bewaarkolom',
        'retention_period' => 'Bewaartermijn',
        'period_unit' => 'Periode-eenheid',
        'action' => 'Actie',
        'anonymize_fields' => 'Te anonimiseren velden',
        'anonymize_values' => 'Statische waarden',
        'enabled' => 'Ingeschakeld',
        'records_processed' => 'Verwerkt',
        'records_deleted' => 'Verwijderd',
        'records_anonymized' => 'Geanonimiseerd',
        'status' => 'Status',
        'started_at' => 'Gestart om',
        'finished_at' => 'Geëindigd om',
        'error' => 'Fout',
        'data_subject' => 'Betrokkene',
        'path' => 'Pad',
        'size' => 'Grootte',
        'created_at' => 'Aangemaakt op',
        'policy' => 'Beleid',
    ],

];
