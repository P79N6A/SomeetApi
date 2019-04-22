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
use app\models\SpaceSpot;
use app\models\FounderSpaceSpot;
use app\models\ActivityBlack;
use app\models\CollectAct;
use app\models\ActivityType;
use app\common\service\ActivityService;
use app\common\service\SpaceService;
use app\common\service\MemberService;
use app\common\service\ActivityTagService;
use app\models\UserSelectTags;
use Yii;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\modules\v1\controllers\BaseController;

class SpaceController extends BaseController
{
	public $modelClass = 'app\models\SpaceSpot';
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
				'get-space-list',
				'get-list',
				'get-info',
				'add'
			]
		];
		$behaviors['access'] = [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'get-space-list',
                    'get-list',
                    'get-info',
                    'add'
                ],
            ];
		return $behaviors;
	}

	/**
	 * 获取发起人场地信息
	 */
	public function actionGetSpaceList($user_id,$type='founder'){
		if($user_id == 1) $type = 'admin';
		$list = SpaceService::getList($user_id,$type);
		return $list;
	}

	/**
	 * 分页获取场地列表
	 */
	public function actionGetList($page,$limit=10,$type='founder'){
		$data['page'] = $page;
		$data['type'] = $type;
		$data['limit'] = $limit;
		$list = SpaceService::getListByPage($data);
		return $list;
	}
	/**
	 * 获取单个场地的详细信息
	 */
	public function actionGetInfo($id=0){
		if(!intval($id)){
			return ['status'=>0,'data'=>'数据获取错误'];
		}
		$type = 'founder';
		$data = SpaceService::getSpace($id,$type);
		return $data;
	}
	/**
	 * 修改和添加场地
	 */
	public function actionAdd(){
		$request = Yii::$app->request;
		$data = $request->post();
		// $user_id = Yii::$app->user->id;
		$user_id = 2961;
		$data['user_id'] = $user_id;
		$data['type'] = $user_id == 1?'admin':'founder';
		$type = $request->isPut?'isPut':'isPost';
		$res = SpaceService::edit($data,$type);
		return is_array($res)?['status'=>0,'data'=>'error']:['status'=>1,'data'=>'ok'];
	}






}