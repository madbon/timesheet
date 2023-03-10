<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_item}}',
            'assignmentTable' => '{{%auth_assignment}}',
            'itemChildTable' => '{{%auth_item_child}}',
            'ruleTable' => '{{%auth_rule}}',
            'defaultRoles' => ['admin'],
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'common\modules\admin\Module',
        ],
    ],
    'name' => 'BPSU Timesheet Monitoring System for CICT Trainees',
];
