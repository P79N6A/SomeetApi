<?php
namespace app\modules\back\controllers;


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
use app\common\service\MemberService;
use app\models\UserSelectTags;
use Yii;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\modules\v1\controllers\BaseController;

class MemberController extends BaseController
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
				'get-list',
				'update-status'
			]
		];
		$behaviors['access'] = [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'get-list',
                    'update-status'
                ],
            ];
		return $behaviors;
	}

	public function actionGetList(){
		$request = Yii::$app->request;
		$params = $request->get();
		$data =[
			'is_founder'=>isset($params['is_founder'])?$params['is_founder']:0,
			'is_black'=>isset($params['is_black'])?$params['is_black']:0,
			'is_lock'=>isset($params['is_lock'])?$params['is_lock']:0,
			'is_apply'=>isset($params['is_apply'])?$params['is_apply']:0,
			'is_all'=>isset($params['is_all'])?$params['is_all']:0,
			'is_admin'=>isset($params['is_admin'])?$params['is_admin']:0
		];
		$list = MemberService::getList($data);
		return $list;
	}

	/**
	 * 更新用户的状态
	 */
	public function actionUpdateStatus(){
		$data = Yii::$app->request->post();
		if(!isset($data['type']) || !isset($data['status'])){
			return ['status'=>0,'msg'=>'参数故障，无法处理'];
		}
		if(!in_array($data['type'],['black','lock','unblack','unlock'])){
			return ['status'=>0,'msg'=>'操作不当'];
		}
		$res = MemberService::updateStatus($data);
		return $res?[
			'status'=>1,
			'msg'=>'操作成功'
		]:[
			'status'=>0,
			'msg'=>'操作失败'
		];
	}
}