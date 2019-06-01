<?php
namespace app\modules\v1\controllers;


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
use app\common\service\ActivityService;
use app\common\service\AnswerService;
use Yii;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\modules\v1\controllers\BaseController;

class AnswerController extends BaseController{
	public $modelClass = 'app\models\Answer';
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
				'check-answer',
				'create'
				
			]
		];
		$behaviors['access'] = [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'check-answer',
                    'create'
                ],
            ];
		return $behaviors;
	}

	public function actionCheckAnswer($id){
		return AnswerService::checkAnswer($id);
	}

	/**
	 * 开始创建报名流程
	 */
	public function actionCreate(){
		$request = Yii::$app->request;
		if(!$request->isPost){
			return ['status'=>0,'msg'=>'禁止的报名方式'];
		}
		$data = $request->post();
		// 检查活动是否设置了回答问题
		$isSetQuestion = Activity::find()->select(['is_set_question'])->where(['id'=>$data['id']])->one();
		if(!$is_set_question){
			return ['status'=>1,'msg'=>'设置了回答问题','is_set_question'=>1];
		}
	}
}