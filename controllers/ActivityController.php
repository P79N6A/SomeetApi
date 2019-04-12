<?php
namespace app\controllers;
use Yii;
use app\component\BaseController;
use yii\web\Response;
use app\models\Activity;
use app\common\service\ActivityService;
use app\models\User;
use yii\filters\AccessControl;
use yii\base\ActionFilter;

class ActivityController extends BaseController{
	
	public function behaviors(){
        return [
            'access' => [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'index',
                    'add',
                    'msg',
                    'check'
                ],
            ],
        ];

    }
	/**
     * 活动列表首页
     */
	public function actionIndex($page=1,$status=20,$is_history=0){
        $data['page'] = $page;
        $data['status'] = $status;
        $data['is_history'] = $is_history;
        if($data['is_history'] == 0){
            unset($data['status']);
        }
        $list = ActivityService::getActlist($data);
        if($list['count'] >0){
            foreach ($list['data'] as $key=>$row) {
                //获取活动的发起人姓名
                $user = User::find()->select(['username','id'])->where(['id'=>$row['created_by']])->asArray()->one();
                if($user && isset($user['username'])){
                    $list[$key]['username'] = $user['username'];
                }
            }
        }
		return $this->render('index');
	}
    /**
     * 活动审核首页
     */
    public function actionCheck(){
        return $this->render('check');
    }
    /**
     * 添加活动页面
     */
    public function actionAdd(){
        return $this->render('add');
    }
	public function actionSignUp(){
		$prefix = '/' . Yii::$app->id . '/';
        $admin = User::findOne(1);
        Yii::$app->user->login($admin);
        // 增加了以下三行：
        $auth = Yii::$app->authManager;
        echo '<pre>';
        var_dump(Yii::$app->user->can('createPost'));
        die;
	}
    /**
     * 人工客服也
     */
    public function actionMsg(){
        return $this->render('msg');
    }
}