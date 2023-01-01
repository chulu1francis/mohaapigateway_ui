<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
);

return [
    'id' => 'aucsoap-frontend',
    'name' => $params['siteName'],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'homeUrl' => '',
    'timeZone' => 'Africa/Lusaka',
    'components' => [
        'request' => [
            'csrfParam' => 'aucsoap_csrf-frontend',
            'csrfCookie' => [
                'httpOnly' => true,
                'secure' => true,
            ],
            'baseUrl' => ''
        ],
        'user' => [
            'identityClass' => 'frontend\models\Organisations',
            'enableAutoLogin' => false,
            'loginUrl' => ['site/login'],
            'authTimeout' => 1 * 24 * 60 * 60,
            'identityCookie' => ['name' => 'aucsoap_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            'class' => 'yii\redis\Session',
            'timeout' => 1800,
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 0,
            ],
            'name' => 'aucsoap-frontend',
            'cookieParams' => [
                'lifetime' => 1 * 24 * 60 * 60,
                'secure' => true,
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
            'useMemcached' => true,
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
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'hostInfo' => $params['host'],
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
