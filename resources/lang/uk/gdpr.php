<?php

// translations for ElvinQulizade/Gdpr — Ukrainian
return [

    'plugin' => [
        'name' => 'Конфіденційність',
        'navigation_group' => 'GDPR',
    ],

    'policy' => [
        'label' => 'Політика зберігання',
        'plural_label' => 'Політики зберігання',
        'navigation_label' => 'Зберігання',
    ],

    'runs' => [
        'title' => 'Запуски конфіденційності',
        'navigation_label' => 'Запуски конфіденційності',
        'empty' => 'Журналів запусків ще немає.',
        'retry' => 'Повторити політику',
        'retry_failed' => 'Повторити невдалі політики',
        'success' => 'Політику успішно виконано.',
    ],

    'dsar' => [
        'title' => 'Запит суб’єкта даних',
        'navigation_label' => 'Суб’єкт даних',
        'email' => 'Email суб’єкта даних',
        'submit' => 'Сформувати експорт',
        'generating' => 'Формування експорту…',
        'success' => 'Експорт персональних даних сформовано.',
        'invalid_association' => 'Не вдалося захистити дані.',
        'export_your_data' => 'Експортуйте свої дані',
        'exported' => 'Персональні дані експортовано',
    ],

    'anonymization' => [
        'static_placeholder' => 'Закрито',
    ],

    'widgets' => [
        'enabled_policies' => 'Активні політики',
        'total_deleted' => 'Видалено записів',
        'total_anonymized' => 'Анонімізовано записів',
        'exports' => 'Експорти даних',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Анонімізувати',
            'delete' => 'Видалити',
        ],
        'period_units' => [
            'days' => 'дн.',
            'months' => 'міс.',
            'years' => 'р.',
        ],
        'strategies' => [
            'null' => 'Установити null',
            'random' => 'Випадкове значення',
            'mask' => 'Маска',
            'static' => 'Статичне значення',
        ],
        'run_statuses' => [
            'running' => 'Виконується',
            'succeeded' => 'Успішно',
            'failed' => 'Помилка',
        ],
        'export_statuses' => [
            'processing' => 'Обробка',
            'completed' => 'Завершено',
            'failed' => 'Помилка',
        ],
    ],

    'fields' => [
        'name' => 'Назва',
        'model_class' => 'Цільова модель',
        'retention_column' => 'Колонка зберігання',
        'retention_period' => 'Період зберігання',
        'period_unit' => 'Одиниця періоду',
        'action' => 'Дія',
        'anonymize_fields' => 'Поля для анонімізації',
        'anonymize_values' => 'Статичні значення',
        'enabled' => 'Активна',
        'records_processed' => 'Оброблено',
        'records_deleted' => 'Видалено',
        'records_anonymized' => 'Анонімізовано',
        'status' => 'Статус',
        'started_at' => 'Розпочато в',
        'finished_at' => 'Завершено в',
        'error' => 'Помилка',
        'data_subject' => 'Суб’єкт даних',
        'path' => 'Шлях',
        'size' => 'Розмір',
        'created_at' => 'Створено',
        'policy' => 'Політика',
    ],

];
