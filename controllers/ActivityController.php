<?php
namespace app\controllers;
use Yii;
use app\component\BaseController;
use yii\web\Response;
use app\models\Activity;
use app\common\service\ActivityService;
use app\common\service\SpaceService;
use app\common\service\ActivityTagService;
use app\models\User;
use app\common\service\MemberService;
use app\common\service\ActivityTypeService;
use yii\filters\AccessControl;
use yii\base\ActionFilter;

class ActivityController extends BaseController{
	
	public function behaviors(){
        return [
            'access' => [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    // 'index',
                    'add',
                    'msg',
                    'check',
                    'get-tag',
                    'create-act',
                    'answer'
                ],
            ],
        ];

    }
    /**
     * 报名管理
     */
    public function actionAnswer($id=0){
        $this->layout = "view";
        if($id){
            //查询所有报名的用户
            $count = ActivityService::getAnswersCount($id);
            // echo '<pre>';
            // var_dump($list);
            // die;
        }
        return $this->render('answer',['count'=>$count,'aid'=>$id]);
    }
	/**
     * 活动列表首页
     */
	public function actionIndex($page=1,$status=20,$is_history=0,$limit =30){
        $data['page'] = $page;
        $data['status'] = $status;
        $data['is_history'] = $is_history;
        $data['limit'] =$limit;
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
    public function actionAdd($id = 0){
        $data['id'] = $id;

        //获取所有小海豹的信息 2961,45388,50575,71887,71904
        $data['xhb'] = MemberService::getServiceMan();
        //获取所有发起人的信息
        $data['founder'] = MemberService::getFounders(71904);
        //获取所有可用的活动类型
        $data['typelist'] = ActivityTypeService::GetList();
        //获取场地信息
        $data['space'] = SpaceService::getList(297962,'someet');
        //获取活动详情
        $detail = ActivityService::getDetail($id);
        $data['detail'] = $detail;
        //二级分类
        $data['tagName'] = ActivityTypeService::GetTag($detail['tag_id']);
        return $this->render('old_add',['data'=>$data]);
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