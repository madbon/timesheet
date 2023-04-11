<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'name' => 'BPSU OJT Timesheet Monitoring System for CICT Trainees', 
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'capture-login-no-facial-recog' => 'site/capture-login-no-facial-recog',
                'login-with-image' => 'site/login-with-image', // Add this line
                'capture-register' => 'site/capture-register',
                'capture-login-with-facial-recog' => 'site/capture-login-with-facial-recog',
                'confirm-profile' => 'site/confirm-profile',
                'index' => 'site/index',
                'confirm-profile-success' => 'site/confirm-profile-success',
            ],
        ],
    ],
    // 'defaultRoute' => 'site/capture-login-with-facial-recog',
    'defaultRoute' => 'site/capture-login-no-facial-recog',
    'params' => $params,
];
