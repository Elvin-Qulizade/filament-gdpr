<?php

// translations for ElvinQulizade/Gdpr — Brazilian Portuguese
return [

    'plugin' => [
        'name' => 'Privacidade',
        'navigation_group' => 'LGPD',
    ],

    'policy' => [
        'label' => 'Política de retenção',
        'plural_label' => 'Políticas de retenção',
        'navigation_label' => 'Retenção',
    ],

    'runs' => [
        'title' => 'Execuções de privacidade',
        'navigation_label' => 'Execuções de privacidade',
        'empty' => 'Ainda não há registros de execução.',
        'retry' => 'Repetir política',
        'retry_failed' => 'Repetir políticas com falha',
        'success' => 'Política executada com sucesso.',
    ],

    'dsar' => [
        'title' => 'Solicitação do titular',
        'navigation_label' => 'Titular',
        'email' => 'E-mail do titular',
        'submit' => 'Gerar exportação',
        'generating' => 'Gerando exportação…',
        'success' => 'A exportação de dados pessoais foi gerada.',
        'invalid_association' => 'Não foi possível proteger os dados.',
        'export_your_data' => 'Exporte seus dados',
        'exported' => 'Dados pessoais exportados',
    ],

    'anonymization' => [
        'static_placeholder' => 'Redigido',
    ],

    'widgets' => [
        'enabled_policies' => 'Políticas ativas',
        'total_deleted' => 'Registros excluídos',
        'total_anonymized' => 'Registros anonimizados',
        'exports' => 'Exportações de dados',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Anonimizar',
            'delete' => 'Excluir',
        ],
        'period_units' => [
            'days' => 'dias',
            'months' => 'meses',
            'years' => 'anos',
        ],
        'strategies' => [
            'null' => 'Definir como nulo',
            'random' => 'Valor aleatório',
            'mask' => 'Máscara',
            'static' => 'Valor estático',
        ],
        'run_statuses' => [
            'running' => 'Em execução',
            'succeeded' => 'Sucesso',
            'failed' => 'Falhou',
        ],
        'export_statuses' => [
            'processing' => 'Processando',
            'completed' => 'Concluído',
            'failed' => 'Falhou',
        ],
    ],

    'fields' => [
        'name' => 'Nome',
        'model_class' => 'Modelo de destino',
        'retention_column' => 'Coluna de retenção',
        'retention_period' => 'Período de retenção',
        'period_unit' => 'Unidade do período',
        'action' => 'Ação',
        'anonymize_fields' => 'Campos para anonimizar',
        'anonymize_values' => 'Valores estáticos',
        'enabled' => 'Ativada',
        'records_processed' => 'Processados',
        'records_deleted' => 'Excluídos',
        'records_anonymized' => 'Anonimizados',
        'status' => 'Status',
        'started_at' => 'Iniciado em',
        'finished_at' => 'Finalizado em',
        'error' => 'Erro',
        'data_subject' => 'Titular',
        'path' => 'Caminho',
        'size' => 'Tamanho',
        'created_at' => 'Criado em',
        'policy' => 'Política',
    ],

];
