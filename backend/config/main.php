<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
);

return [
    'id' => 'moha_api_gateway-backend',
    'name' => $params['siteName'],
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'homeUrl' => '/administration',
    'components' => [
        'request' => [
            'csrfParam' => 'moha_api_gateway_csrf-backend',
            'csrfCookie' => [
                'httpOnly' => true,
                'secure' => false,
            ],
            'baseUrl' => '/administration'
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => false,
            'loginUrl' => ['site/login'],
            'authTimeout' => 900, //15minutes
            'identityCookie' => [
                'name' => 'moha_api_gateway_identity-backend',
                'httpOnly' => true
                ],
        ],
        'session' => [
            'class' => 'yii\redis\Session',
            'timeout' => 900, //15minutes
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 0,
            ],
            'name' => 'moha_api_gateway-backend',
            'cookieParams' => [
                'lifetime' => 1 * 24 * 60 * 60,
            ],
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 0,
            ]
        ],
//        'cache' => [
//            'class' => 'yii\caching\MemCache',
//            'servers' => [
//                [
//                    'host' => '127.0.0.1',
//                    'port' => 11211,
//                    'weight' => 100,
//                ],
//            ],
//            'useMemcached' => true,
//        ],
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
