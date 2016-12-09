<?php

if (file_exists(__DIR__ . '/user.params.php')) {
	$params = require(__DIR__ . '/user.params.php');
} else {
	$params = require(__DIR__ . '/params.php');
}

$config = [
    'id' => 'OMG',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'defaultRoute' => 'imageteller',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'OMG',
			'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'imageteller/error',
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
					'levels' => ['error', 'warning', 'info'],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['info'],
					'logFile' => __DIR__ . '/../runtime/logs/info/info.log',
					'logVars' => [],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['warning'],
					'logFile' => __DIR__ . '/../runtime/logs/warning/warning.log',
					'logVars' => [],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error'],
					'logFile' => __DIR__ . '/../runtime/logs/error/error.log',
					'logVars' => [],
				],
			],
		],
        'db' => require(__DIR__ . '/db.php'),
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'enableStrictParsing' => false,
			'rules' => [
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',	
			],
		],
    ],
    'params' => $params,
];

/*
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}
*/
return $config;
