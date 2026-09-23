<?php

// translations for ElvinQulizade/Gdpr — Russian
return [

    'plugin' => [
        'name' => 'Конфиденциальность',
        'navigation_group' => 'GDPR',
    ],

    'policy' => [
        'label' => 'Политика хранения',
        'plural_label' => 'Политики хранения',
        'navigation_label' => 'Хранение',
    ],

    'runs' => [
        'title' => 'Запуски конфиденциальности',
        'navigation_label' => 'Запуски конфиденциальности',
        'empty' => 'Журналов запусков пока нет.',
        'retry' => 'Повторить политику',
        'retry_failed' => 'Повторить неудачные политики',
        'success' => 'Политика успешно выполнена.',
    ],

    'dsar' => [
        'title' => 'Запрос субъекта данных',
        'navigation_label' => 'Субъект данных',
        'email' => 'Email субъекта данных',
        'submit' => 'Сформировать экспорт',
        'generating' => 'Формирование экспорта…',
        'success' => 'Экспорт персональных данных сформирован.',
        'invalid_association' => 'Не удалось защитить данные.',
        'export_your_data' => 'Экспортировать ваши данные',
        'exported' => 'Персональные данные экспортированы',
    ],

    'anonymization' => [
        'static_placeholder' => 'Скрыто',
    ],

    'widgets' => [
        'enabled_policies' => 'Активные политики',
        'total_deleted' => 'Удалено записей',
        'total_anonymized' => 'Анонимизировано записей',
        'exports' => 'Экспорты данных',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => 'Анонимизировать',
            'delete' => 'Удалить',
        ],
        'period_units' => [
            'days' => 'дней',
            'months' => 'месяцев',
            'years' => 'лет',
        ],
        'strategies' => [
            'null' => 'Установить null',
            'random' => 'Случайное значение',
            'mask' => 'Маска',
            'static' => 'Статическое значение',
        ],
        'run_statuses' => [
            'running' => 'Выполняется',
            'succeeded' => 'Успешно',
            'failed' => 'Ошибка',
        ],
        'export_statuses' => [
            'processing' => 'Обработка',
            'completed' => 'Завершено',
            'failed' => 'Ошибка',
        ],
    ],

    'fields' => [
        'name' => 'Название',
        'model_class' => 'Целевая модель',
        'retention_column' => 'Колонка хранения',
        'retention_period' => 'Период хранения',
        'period_unit' => 'Единица периода',
        'action' => 'Действие',
        'anonymize_fields' => 'Поля для анонимизации',
        'anonymize_values' => 'Статические значения',
        'enabled' => 'Активна',
        'records_processed' => 'Обработано',
        'records_deleted' => 'Удалено',
        'records_anonymized' => 'Анонимизировано',
        'status' => 'Статус',
        'started_at' => 'Начато в',
        'finished_at' => 'Завершено в',
        'error' => 'Ошибка',
        'data_subject' => 'Субъект данных',
        'path' => 'Путь',
        'size' => 'Размер',
        'created_at' => 'Создано',
        'policy' => 'Политика',
    ],

];
