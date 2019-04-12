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
	public function actionIndex($page=1,$status=20,$is_history=0){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$data['page'] = $page;
        $data['status'] = $status;
        $data['is_history'] = $is_history;
        if($data['is_history'] == 0){
            unset($data['status']);
        }
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
		$model = Activity::find()->where(['id'=>$id])->asArray()->one();
		//获取该活动的类型详情
		$type = ActivityType::find()->select(['id','icon_img','name'])->where(['id'=>$model['type_id']])->asArray()->one();
		$model['type'] = $type;
		//判断是否被收藏
		$is_collect  = CollectAct::find()->where(['user_id'=>$user_id,'activity_id'=>$id])->exists();
		$model['is_collect'] = $is_collect?1:0;
		//判断是否拉黑此活动
		$is_black = ActivityBlack::find()->where(['sequence_id'=>$model['sequence_id']])->orWhere(['id'=>$id])->exists();
		$model['is_black'] = $is_balck;
		//获取该活动发起人的详细信息,标签,头像,昵称,简介
		$profile = Profile::find()->select(['headimgurl'])->where(['user_id'=>$model['created_by']])->asArray()->one();
		$user = User::find()->select(['username','founder_desc'])->where(['id'=>$model['created_by']])->asArray()->one();
		$tags = CommonFunction::getUserTags(['user_id'=>$model['created_by']],[],10);
		$model['profile'] = $profile;
		$model['user'] = $user;
		$model['tags'] = $tags;
		//获取哪些用户也参加了这场活动
		$answers = Answer::find()->select(['answer.id','answer.activity_id','answer.user_id'])->joinWith(['profile','user'])->where(['activity_id'=>$model['id']])->asArray()->all();
		$model['answers'] = $answers;
		return $model;
	}

}