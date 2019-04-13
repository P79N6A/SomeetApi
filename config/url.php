<?php
return [
	'member/<id:\d+>' => 'member/view', //活动详情
	[
        'class' => 'yii\rest\UrlRule',
        'controller' => [
			'v1/activity',
			'v1/wechat',
			'lark/index',
			'back/activity'
        ]
    ],
    //前端api
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => [
			'v1/activity'
		],
		'extraPatterns' => [
			'GET index' => 'index'
		]
	],
	//前端微信sdk
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
			'GET get-member'=>'get-member',
			'GET send-to-single'=>'send-to-single',
			'GET chat-bot'=>'chat-bot',
			'GET get-log-list'=>'get-log-list'
		]
	],
	//后台api
	//前端api
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => [
			'back/activity'
		],
		'extraPatterns' => [
			'GET index' => 'index'
		]
	],
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => [
			'back/member'
		],
		'extraPatterns' => [
			'GET get-list' => 'get-list',
			'POST update-status' => 'update-status',
			'POST get-info' => 'get-info'
		]
	],
];