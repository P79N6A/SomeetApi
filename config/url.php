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
			'GET index' => 'index',
			'GET get-tag'=>'get-tag',
			'GET get-sequence'=>'get-sequence',
			'POST create-act'=>'create-act',
			'GET index-by-founder'=>'index-by-founder',
			'GET get-more-answer'=>'get-more-answer'
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
			'POST get-info' => 'get-info',
			'POST role-update'=>'role-update',
			'GET get-user-search'=>'get-user-search',
			'GET founder-check'=>'founder-check'
			
		]
	],
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => [
			'back/classify'
		],
		'extraPatterns' => [
			'POST create-top' => 'create-top',
			'POST create-sub' => 'create-sub',
			'GET get-top' => 'get-top',
			'POST update-status' => 'update-status',
			'POST update-sub-status' => 'update-sub-status',
		]
	],
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => [
			'back/upload'
		],
		'extraPatterns' => [
			'POST upload-image' => 'upload-image',
			'POST upload-file' => 'upload-file'
		]
	],
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => [
			'back/space'
		],
		'extraPatterns' => [
			//获取发起人场地的列表
			'GET get-space-list' => 'get-space-list',
			//获取单个场地的详细信息
			'GET get-info' => 'get-info',
			//获取场地列表
			'GET get-list' => 'get-list',
			//添加修改场地
			'POST add'=>'add',
			'PUT add'=>'add'
		]
	],
];