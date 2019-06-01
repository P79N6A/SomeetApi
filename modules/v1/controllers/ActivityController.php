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
use Yii;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\modules\v1\controllers\BaseController;

class ActivityController extends BaseController
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
				'index',
				'view',
				
			]
		];
		$behaviors['access'] = [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'index',
					'view'
                ],
            ];
		return $behaviors;
	}
	public function actionIndex(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$city_id = [2,3,4];
		$data = Activity::find()
            ->joinWith('type')
            ->where(
                ['and',
                    ['activity.city_id' => $city_id],
                    ['activity.is_new' => [0, 2]],
                    ['activity_type.status' => ActivityType::STATUS_NORMAL],
                    ['>', 'activity.end_time', getLastEndTime()],
                    ['is_display' => Activity::DISPLAY_YES],
                    ['or',
                        ['activity.status' => Activity::STATUS_RELEASE],
                        ['activity.status' => Activity::STATUS_SHUT],
                    ],
                ]
            );
		$pages = new Pagination(['totalCount' => $data->count()]);
        $activities = $data->offset($pages->offset)->limit($pages->limit)
			->select([
				'activity.title',
				'activity.poster',
				'activity.desc',
				'activity.id',
				'activity.type_id',
				'activity.status',
				'activity.is_full',
				'activity.display_order',
				'activity.apply_rate',
				'activity.is_top',
				'activity.city_id'
				])
            ->asArray()
            ->orderBy(
                [
                'activity.is_full' => SORT_ASC, //是否报满正序
                'case when `activity`.`status` = 30 then 0 else 1 end' => SORT_DESC, //活动关闭沉底
                'activity.is_top' => SORT_DESC, //置顶降序
                'activity.display_order' => SORT_ASC, //手动排序正序
                'activity.apply_rate' => SORT_ASC, //报名率
                'activity.id' => SORT_DESC, //编号排序倒序
                ]
            )
            ->all();
		return $activities;
	}
	/**
	 * 获取单个活动的详细内容
	 */
	public function actionView($id=0){
		$user_id = 2961;
		if(intval($id) == 0) return false;
		$model = ActivityService::getView($id);
		return $model;
	}

}