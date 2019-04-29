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
use app\common\service\ActivityService;
use app\common\service\ActivityTypeService;
use app\common\service\ClassifyService;
use app\common\service\ActivityTagService;
use app\models\UserSelectTags;
use Yii;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\modules\v1\controllers\BaseController;

class ClassifyController extends BaseController
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
				// 'index-by-founder'
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


	/**
	 * 获取列表
	 */
	public function actionGetList($page=1,$limit=30,$type=0){
		$data['page'] = $page;
        $data['limit'] = $limit;
        $data['type'] = $type;
        $list = ActivityTypeService::getListByPage($data);
		return $list;
	}
	/**
	 * 修改显示状态
	 */
	/**
	 * 更新用户的状态
	 */
	public function actionUpdateStatus(){
		$data = Yii::$app->request->post();
		if(!isset($data['type']) || !isset($data['status'])){
			return ['status'=>0,'msg'=>'参数故障，无法处理'];
		}
		if(!in_array($data['type'],['show','hide'])){
			return ['status'=>0,'msg'=>'操作不当'];
		}
		$res = ActivityTypeService::updateStatus($data);
		return $res?[
			'status'=>1,
			'msg'=>'操作成功'
		]:[
			'status'=>0,
			'msg'=>'操作失败'
		];
	}
}