<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
	'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ],
		'lark' => [
		    'class' => 'app\modules\lark\Module',
		],
        'back' => [
            'class' => 'app\modules\back\Module',
        ]
    ],
    'components' => [
		'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => 'google_client_id',
                    'clientSecret' => 'google_client_secret',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => 'facebook_client_id',
                    'clientSecret' => 'facebook_client_secret',
                ],
                // etc.
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'qiniu' => [
            'class' => 'app\component\QiniuComponent',
            'accessKey' => 'jJuHkknaHQbKbX8i-WuazueI2g1yHwNnPaKLSOmX',
            'secretKey' =>'aVAnrg6JqxBivDzbhKiJ5LM-8QubxvWtBud0vWC1',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Someet',
        ],
		'response' => [
			'class' => 'yii\web\Response',
			'on beforeSend' => function ($event) {
                /* @var \yii\web\Response $response */
                $response = $event->sender;
                if ($response->format == \yii\web\Response::FORMAT_JSON && Yii::$app->controller->module->id !=='lark') {
                    if ($response->isSuccessful) {
                        $data['success'] = "1";
                        $data['data'] = $response->data;
                    } else {
                        $data['success'] = "0";

                        if (!empty($response->data['message'])) {
                            $data['errmsg'] = $response->data["message"];
                        } else {
                            $data['errmsg'] = $response->data["name"];
                        }
                    }
                    $data['status_code'] = $response->statusCode;
                    $response->data = $data;
                    $response->statusCode = 200;
                }
            }
		],
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '123.56.179.91',
            'port' => 6379,
            'password' => 'Someet',
            'database' => 0,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
			'loginUrl'=>'/site/login'
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
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require('url.php'),
        ],
       
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*']
    ];
}

return $config;
