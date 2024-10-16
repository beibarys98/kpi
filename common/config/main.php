<?php
return [
    'defaultRoute' => '/site/login',
    'timeZone' => 'Asia/Tashkent',
    'on beforeRequest' => function ($event) {
        Yii::$app->language = Yii::$app->session->get('language', 'kz-KZ');
    },

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

    'components' => [
        'formatter' => [
            'datetimeFormat' => 'php: d-m-Y, H:i:s',
            'locale' => 'ru'
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],

        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
];
