<?php
return [
	[
        'class' => 'yii\rest\UrlRule',
        'controller' => [
			'v1/activity',
			'v1/wechat',
			'lark/index'
        ]
    ],
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => [
			'v1/activity'
		],
		'extraPatterns' => [
			'GET index' => 'index'
		]
	],
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => [
			'v1/wechat'
		],
		'extraPatterns' => [
			'GET get-access-token' =>'get-access-token'
		]
	],
	//lark 回调地址
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => [
			'lark/token'
		],
		'extraPatterns' => [
			'POST token' =>'token'
		]
	],
];