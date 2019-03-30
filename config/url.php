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
			'lark/index'
		],
		'extraPatterns' => [
			'POST token' =>'token',
			'GET get-token'=>'get-token',
			'GET get-group-list'=>'get-group-list',
			'GET send-to-group'=>'send-to-group',
			'GET get-member'=>'get-member'
		]
	],
];