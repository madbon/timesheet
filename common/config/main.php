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
    ],
    'modules' => [
        'admin' => [
            'class' => 'common\modules\admin\Module',
        ],
    ],
    'name' => 'BPSU Timesheet Monitoring System for CICT Trainees',
];
