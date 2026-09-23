<?php

// translations for ElvinQulizade/Gdpr — Spanish
return [

    'plugin' => [
        'name' => 'Privacidad',
        'navigation_group' => 'RGPD',
    ],

    'policy' => [
        'label' => 'Política de retención',
        'plural_label' => 'Políticas de retención',
        'navigation_label' => 'Retención',
    ],

    'runs' => [
        'title' => 'Ejecuciones de privacidad',
        'navigation_label' => 'Ejecuciones de privacidad',
        'empty' => 'Aún no hay registros de ejecución.',
        'retry' => 'Reintentar política',
        'retry_failed' => 'Reintentar políticas fallidas',
        'success' => 'Política ejecutada con éxito.',
    ],

    'dsar' => [
        'title' => 'Solicitud de interesado',
        'navigation_label' => 'Interesado',
        'email' => 'Correo del interesado',
        'submit' => 'Generar exportación',
        'generating' => 'Generando exportación…',
        'success' => 'Se ha generado la exportación de datos personales.',
        'invalid_association' => 'No se pudieron proteger los datos.',
        'export_your_data' => 'Exporta tus datos',
        'exported' => 'Datos personales exportados',
    ],

    'anonymization' => [
        'static_placeholder' => 'Redactado',
    ],

    'widgets' => [
        'enabled_policies' => 'Políticas activas',
        'total_deleted' => 'Registros eliminados',
        'total_anonymized' => 'Registros anonimizados',
        'exports' => 'Exportaciones de datos',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Anonimizar',
            'delete' => 'Eliminar',
        ],
        'period_units' => [
            'days' => 'días',
            'months' => 'meses',
            'years' => 'años',
        ],
        'strategies' => [
            'null' => 'Establecer a nulo',
            'random' => 'Valor aleatorio',
            'mask' => 'Enmascarar',
            'static' => 'Valor estático',
        ],
        'run_statuses' => [
            'running' => 'En ejecución',
            'succeeded' => 'Correcto',
            'failed' => 'Fallido',
        ],
        'export_statuses' => [
            'processing' => 'Procesando',
            'completed' => 'Completado',
            'failed' => 'Fallido',
        ],
    ],

    'fields' => [
        'name' => 'Nombre',
        'model_class' => 'Modelo de destino',
        'retention_column' => 'Columna de retención',
        'retention_period' => 'Período de retención',
        'period_unit' => 'Unidad de período',
        'action' => 'Acción',
        'anonymize_fields' => 'Campos a anonimizar',
        'anonymize_values' => 'Valores estáticos',
        'enabled' => 'Habilitada',
        'records_processed' => 'Procesados',
        'records_deleted' => 'Eliminados',
        'records_anonymized' => 'Anonimizados',
        'status' => 'Estado',
        'started_at' => 'Iniciado a las',
        'finished_at' => 'Finalizado a las',
        'error' => 'Error',
        'data_subject' => 'Interesado',
        'path' => 'Ruta',
        'size' => 'Tamaño',
        'created_at' => 'Creado el',
        'policy' => 'Política',
    ],

];
