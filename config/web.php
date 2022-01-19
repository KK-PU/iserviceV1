<?php

$params = require(__DIR__ . '/params.php');
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log',
        'app\components\IdentitySwitcher',
        [
            'class' => 'app\components\LanguageSelector',
            'supportedLanguages' => ['en', 'th'],
        ],
	],
	'language' => 'th',
  	'modules' => [
  		'gridview' =>  [
  			'class' => '\kartik\grid\Module'
  		],
      'system' => [
          'class' => 'app\modules\system\Module',
      ],
  	],
    'components' => [
      'formatter' => [
          'class' => 'yii\i18n\Formatter',
          'nullDisplay' => '',
      ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => false,
            ],
        ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'xpZ_dnlkrYzwM1sy5v-do-kPTwoFyz7I',
        ],
        'formatter' => [
		   'defaultTimeZone' => 'UTC',
		   'timeZone' => 'Asia/Bangkok',
		   'dateFormat' => 'php:d-m-Y',
		   'datetimeFormat'=>'php:d-M-Y H:i:s'
        ],

		'session' => [
            'name' => '_it_web_application', //
            'savePath' => __DIR__ . '/../runtime', // a temporary folder
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
           'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@app/mail',
                'useFileTransport' => $params['active'] ,
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => $params['host'],
                    'username' => $params['adminEmail'] ,
                    'password' => $params['password'],
                    'port' => $params['port'],
                    'encryption' => $params['encryption'],
                    'streamOptions' => [
                       'ssl' => [
                          'allow_self_signed' => true,
                          'verify_peer' => false,
                          'verify_peer_name' => false,
                       ]
                    ]
                ],
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
        'datethai' => [
           'class' => 'app\components\DateThai'
        ],
        'getdata' => [
           'class' => 'app\components\Custom'
        ],
        'upload' => [
            'class' => 'app\components\upload'
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    /*$config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];*/
}

return $config;
