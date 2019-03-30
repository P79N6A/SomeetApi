<?php
return [
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => [
			'v1/activity',
			'v1/wechat',
			'v2/index'
		],
		'extraPatterns'=>[
			'GET index' => 'index',
		],
		'extraPatterns'=>[
			'GET get-access-token' =>'get-access-token'
		],
		
		
		
		//lark 回调地址
		'extraPatterns'=>[
			'GET index' =>'index'
		],
		'extraPatterns'=>[
			'POST index' =>'index'
		]
	],
];