<?php
namespace app\modules\lark\controllers;


use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use app\component\CommonFunction;
use app\models\Activity;
use app\models\Profile;
use app\models\User;
use app\models\Answer;
use app\models\ActivityBlack;
use app\models\CollectAct;
use app\models\ActivityType;
use app\models\UserSelectTags;
use Yii;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\modules\lark\controllers\BaseController;

class IndexController extends BaseController
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
				'token'
			]
		];
		$behaviors['access'] = [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'token',
                ],
            ];
		$behaviors['verbs'] = [
                'class' => VerbFilter::className(),
                'actions' => [
                    'token' => ['POST'],
                ],
            ];
		return $behaviors;
	}
	/**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if ($action->id == 'token') {
            // 当用户完成交易后 Ping++ 会以 POST 方式把数据发送到你的 hook 地址
            // 所以这时候需要临时关闭掉 Yii 的 CSRF 验证
            Yii::$app->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
	public function actionToken(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$request = Yii::$app->request;
		if(!$request->isPost){
			return false;
		}
		$data = $request->getRawBody();
		$data = json_decode($data,true);
		return isset($data['challenge'])?$data['challenge']:false;
	}

}