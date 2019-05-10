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
use app\common\service\ActivityTagService;
use app\models\UserSelectTags;
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
				'get-tag',
				'get-sequence',
				'create-act',
				'update-status'
				// 'index-by-founder'
			]
		];
		$behaviors['access'] = [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'index',
					'view',
					'get-tag',
					'get-sequence',
					'create-act',
					'index-by-founder',
					'update-status'
                ],
            ];
		return $behaviors;
	}

	public function actionIndex($page=1,$status=20,$limit=10,$is_history=0){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$data['page'] = $page;
        $data['status'] = $status;
        $data['limit'] = $limit;
        $data['is_history'] = $is_history;
        $list = ActivityService::getActlist($data);
        if(!empty($list)){
            foreach ($list['data'] as $key=>$row) {
                //获取活动的发起人姓名
                $user = User::find()->select(['username','id'])->where(['id'=>$row['created_by']])->asArray()->one();
                if($user && isset($user['username'])){
                    $list['data'][$key]['username'] = $user['username'];
                }
            }
        }
        return $list;
	}
	/**
	 * 获取发起人的活动列表
	 */
	public function actionIndexByFounder($page=1,$status=20,$limit=10,$is_history=0){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$data['page'] = $page;
        $data['status'] = $status;
        $data['limit'] = $limit;
        $data['is_history'] = $is_history;
        $data['user_id'] = Yii::$app->user->id;
        $list = ActivityService::getActlist($data);
        if(!empty($list)){
            foreach ($list['data'] as $key=>$row) {
                //获取活动的发起人姓名
                $user = User::find()->select(['username','id'])->where(['id'=>$row['created_by']])->asArray()->one();
                if($user && isset($user['username'])){
                    $list['data'][$key]['username'] = $user['username'];
                }
            }
        }
        return $list;
	}
	/**
	 * 获取单个活动的详细内容
	 */
	public function actionView($id=0){
		if(intval($id) == 0) return false;
		$model = ActivityService::getView($id);       
		return $model;
	}

	/**
     * 获取二级标签
     */
    public function actionGetTag($id){
        $tag = ActivityTagService::getTags($id);
        return $tag;
    }
    /**
     * 获取该发起人的系列活动
     */
    public function actionGetSequence($user_id){
    	return ActivityService::getSequence($user_id);
    }

    /**
     * 创建新的活动
     */
    public function actionCreateAct(){
    	$data = Yii::$app->request->post();
		$res = ActivityService::createAct($data);
		return $res;
    }

    /**
     * 修改活动状态
     */
    public function actionUpdateStatus(){
    	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	$data = Yii::$app->request->post();
    	$status = $data['status'];
    	$id = $data['id'];
    	$reject = $data['reject'];
    	$statusArray = [
            0 => '已删除的活动',
            3 => '审核不通过活动',
            5 => '发起人创建的草稿',
            8 => '发起人待审核活动',
            10 => '草稿',
            12 => '发起人已通过审核活动',
            15 => '预发布',
            20 => '发布',
            30 => '已关闭',
            40 => '取消',
        ];
        
        $activity = Activity::findOne($id);
        $oldStatus = $activity->status;
        $activity->status = $status;
        if ($status == Activity::STATUS_PASS) {
            $activity->updated_by = Yii::$app->user->id;
        }
        if ($status == Activity::STATUS_REFUSE) {
            $activity->reject_reason = $reject;
        }
        if($status == Activity::STATUS_CHECK){
            $activity->push_check_time = time();
        }
        if($status == Activity::STATUS_RELEASE){
            //首次发布时间
            if($activity->first_publish_date == 0){
                $activity->first_publish_date = time();
            }
        }
        if (!$activity->save()) {
        	return ['status'=>0,'data'=>$activity->getErrors()];
        }
        return ['status'=>1,'data'=>'ok'];
    }
}