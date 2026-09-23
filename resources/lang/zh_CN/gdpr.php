<?php

// translations for ElvinQulizade/Gdpr — Chinese (Simplified)
return [

    'plugin' => [
        'name' => '隐私',
        'navigation_group' => 'GDPR',
    ],

    'policy' => [
        'label' => '保留策略',
        'plural_label' => '保留策略',
        'navigation_label' => '保留',
    ],

    'runs' => [
        'title' => '隐私运行',
        'navigation_label' => '隐私运行',
        'empty' => '暂无运行日志。',
        'retry' => '重试策略',
        'retry_failed' => '重试失败的策略',
        'success' => '策略执行成功。',
    ],

    'dsar' => [
        'title' => '数据主体请求',
        'navigation_label' => '数据主体',
        'email' => '数据主体邮箱',
        'submit' => '生成导出',
        'generating' => '正在生成导出…',
        'success' => '个人数据导出已生成。',
        'invalid_association' => '无法保护数据。',
        'export_your_data' => '导出您的数据',
        'exported' => '个人数据已导出',
    ],

    'anonymization' => [
        'static_placeholder' => '已编辑',
    ],

    'widgets' => [
        'enabled_policies' => '已启用策略',
        'total_deleted' => '已删除记录',
        'total_anonymized' => '已匿名化记录',
        'exports' => '数据导出',
    ],

    'enums' => [
        'retention_actions' => [
            'anonymize' => '匿名化',
            'delete' => '删除',
        ],
        'period_units' => [
            'days' => '天',
            'months' => '个月',
            'years' => '年',
        ],
        'strategies' => [
            'null' => '设为 null',
            'random' => '随机值',
            'mask' => '掩码',
            'static' => '静态值',
        ],
        'run_statuses' => [
            'running' => '运行中',
            'succeeded' => '成功',
            'failed' => '失败',
        ],
        'export_statuses' => [
            'processing' => '处理中',
            'completed' => '已完成',
            'failed' => '失败',
        ],
    ],

    'fields' => [
        'name' => '名称',
        'model_class' => '目标模型',
        'retention_column' => '保留列',
        'retention_period' => '保留期',
        'period_unit' => '周期单位',
        'action' => '操作',
        'anonymize_fields' => '要匿名化的字段',
        'anonymize_values' => '静态值',
        'enabled' => '已启用',
        'records_processed' => '已处理',
        'records_deleted' => '已删除',
        'records_anonymized' => '已匿名化',
        'status' => '状态',
        'started_at' => '开始时间',
        'finished_at' => '结束时间',
        'error' => '错误',
        'data_subject' => '数据主体',
        'path' => '路径',
        'size' => '大小',
        'created_at' => '创建时间',
        'policy' => '策略',
    ],

];
