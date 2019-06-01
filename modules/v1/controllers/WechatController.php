<?php
namespace app\modules\v1\controllers;


use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use yii;
use app\modules\v1\controllers\BaseController;

class WechatController extends BaseController
{
	public $modelClass = 'app\models\Activity';
	public function behaviors(){
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => CompositeAuth::className(),
			'authMethods' => [
				HttpBasicAuth::className(),
				HttpBearerAuth::className(),
				QueryParamAuth::className(),
			],
			//暂时解除限制或者未登录就可以访问的方法
			'optional' => [
				'get-access-token',
				'login'
			]
		];
		$behaviors['access'] = [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'get-access-token',
                    'login'
                ],
            ];
		return $behaviors;
	}
	public function actionGetAccessToken(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return 11111;
	}

	//小程序微信登录
	public function actionLogin($code){
		if(!$code) return false;
		$appid = 'wxec563ba322b19c02';
		$secret = '20821b2f5b7b23deff18d18d590b4478';
		$url = sprintf("https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",$appid,$secret,$code);
		return json_decode(file_get_contents($url),true);
	}
}