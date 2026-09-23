<?php

// translations for ElvinQulizade/Gdpr — Italian
return [

    'plugin' => [
        'name' => 'Privacy',
        'navigation_group' => 'GDPR',
    ],

    'policy' => [
        'label' => 'Politica di conservazione',
        'plural_label' => 'Politiche di conservazione',
        'navigation_label' => 'Conservazione',
    ],

    'runs' => [
        'title' => 'Esecuzioni privacy',
        'navigation_label' => 'Esecuzioni privacy',
        'empty' => 'Ancora nessun log di esecuzione.',
        'retry' => 'Riesegui la politica',
        'retry_failed' => 'Riesegui le politiche non riuscite',
        'success' => 'Politica eseguita con successo.',
    ],

    'dsar' => [
        'title' => 'Richiesta dell’interessato',
        'navigation_label' => 'Interessato',
        'email' => 'E-mail dell’interessato',
        'submit' => 'Genera esportazione',
        'generating' => 'Generazione esportazione…',
        'success' => 'L’esportazione dei dati personali è stata generata.',
        'invalid_association' => 'Impossibile proteggere i dati.',
        'export_your_data' => 'Esporta i tuoi dati',
        'exported' => 'Dati personali esportati',
    ],

    'anonymization' => [
        'static_placeholder' => 'Oscurato',
    ],

    'widgets' => [
        'enabled_policies' => 'Politiche attive',
        'total_deleted' => 'Record eliminati',
        'total_anonymized' => 'Record anonimizzati',
        'exports' => 'Esportazioni di dati',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Anonimizza',
            'delete' => 'Elimina',
        ],
        'period_units' => [
            'days' => 'giorni',
            'months' => 'mesi',
            'years' => 'anni',
        ],
        'strategies' => [
            'null' => 'Imposta a null',
            'random' => 'Valore casuale',
            'mask' => 'Maschera',
            'static' => 'Valore statico',
        ],
        'run_statuses' => [
            'running' => 'In esecuzione',
            'succeeded' => 'Riuscito',
            'failed' => 'Non riuscito',
        ],
        'export_statuses' => [
            'processing' => 'Elaborazione',
            'completed' => 'Completato',
            'failed' => 'Non riuscito',
        ],
    ],

    'fields' => [
        'name' => 'Nome',
        'model_class' => 'Modello di destinazione',
        'retention_column' => 'Colonna di conservazione',
        'retention_period' => 'Periodo di conservazione',
        'period_unit' => 'Unità di periodo',
        'action' => 'Azione',
        'anonymize_fields' => 'Campi da anonimizzare',
        'anonymize_values' => 'Valori statici',
        'enabled' => 'Attivata',
        'records_processed' => 'Elaborati',
        'records_deleted' => 'Eliminati',
        'records_anonymized' => 'Anonimizzati',
        'status' => 'Stato',
        'started_at' => 'Iniziato il',
        'finished_at' => 'Terminato il',
        'error' => 'Errore',
        'data_subject' => 'Interessato',
        'path' => 'Percorso',
        'size' => 'Dimensione',
        'created_at' => 'Creato il',
        'policy' => 'Politica',
    ],

];
