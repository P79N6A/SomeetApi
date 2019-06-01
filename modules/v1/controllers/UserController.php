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
use app\common\service\MemberService;
use Yii;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\modules\v1\controllers\BaseController;

class UserController extends BaseController{
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
				'get-info',
				
			]
		];
		$behaviors['access'] = [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'get-info',
                ],
            ];
		return $behaviors;
	}

	/**
	 * 获取用得信息
	 */
	public function actionGetInfo($unionid = ''){
		if(!$unionid) return ['status'=>0,'msg'=>'未获取用户信息'];
		$user = MemberService::getInfo(0,[],$unionid);
		return ['status'=>1,'msg'=>'获取成功','data'=>$user];
	}
}