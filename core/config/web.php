<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'shop',
    'name' => 'shop',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'fa-IR',
    'modules' => [
        'User' => [
            'class' => 'app\modules\User\Module',
        ],
        'Dashbord' => [
            'class' => 'app\modules\Dashbord\Module',
        ],
        'Shop' => [
            'class' => 'app\modules\Shop\Module',
        ],
        'Blog' => [
            'class' => 'app\modules\Blog\Module',
        ],
        'Gallery' => [
            'class' => 'app\modules\Gallery\Module',
        ],
        'Frontend' => [
            'class' => 'app\modules\Frontend\Module',
        ],

    ],
    'components' => [
        'session' => [
            'class' => 'yii\web\DbSession',
            'name' => 'shop',
            'timeout' => 3600,
        ],
        'helper' => ['class' => 'app\components'],
        'authManager' => ['class' => 'yii\rbac\DbManager',],
        'jdate' => ['class' => 'jDate\DateTime'],
        'request' => [
// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'oBpilp6dwUZCmPwRfP35I6oZ0oWNpERj',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'app\modules\Dashbord\components\User',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
// 'useFileTransport' to false and configure a transport
// for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require(__DIR__ . '/routes.php'),
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
// configuration adjustments for 'dev' environment
    /* $config['bootstrap'][] = 'debug';
      $config['modules']['debug'] = [
      'class' => 'yii\debug\Module',
      ]; */

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
