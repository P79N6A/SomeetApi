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

class FounderController extends BaseController{
	public $layout = 'founder';
	public function behaviors(){
        return [
            'access' => [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    // 'index',
                    // 'add',
                    // 'space',
                    // 'member'
                ],
            ],
        ];

    }

    /**
     * 发起人首页列表
     */
    public function actionIndex($page=1,$status=20,$is_history=0,$limit =30){

        return $this->render('index');
    }
    /**
     * 个人中心
     */
    public function actionMember(){
        $this->layout = "view";
        $id = Yii::$app->user->id;  
        $data = MemberService::getInfo($id,['profile','tags','is_admin','is_founder','yellowCard','answers','activity']);
        return $this->render('member',['data'=>$data]);
    }
    /**
    *发起人场地
    */
    public function actionSpace(){
        $user_id = Yii::$app->user->id;
        $data['user_id'] = $user_id;
        return $this->render('space',$data); 
    }
    /**
     * 发起人修改活动
     */
    public function actionAdd($id=0){
        $session = Yii::$app->session;
        $user_id = Yii::$app->user->id;
        //查看当前活动是否是该用户所有
        $own = Activity::find()->select(['created_by'])->where(['id'=>$id])->exists();
        if(!$own && $id >0){
            $session->set('error_msg','该活动拥有者是其他人，无法查看修改');
            return $this->redirect('/site/block');
        }
        $user = User::find()->where(['id'=>$user_id])->select(['status'])->one();
        // 获取发起人的状态
        $founderStatus = MemberService::getFounderStatus($user_id);
        if($founderStatus['idcard_status'] == -1){
            $this->layout = "view";
            return $this->render('useridcard');
            die;
        }
        if($founderStatus['idcard_status'] != 1){
            $this->layout = "view";
            $data['idcard_info'] = $founderStatus['idcard_info'];

            return $this->render('useridcard-loading',['data'=>$data]);
            die;
        }
        if($founderStatus['founderBlockInfo']){
            $session->set('error_msg','你目前处于活动暂缓期');
            return $this->redirect('/site/block');
        }
        if($user->status == -10){
            $session->set('error_msg','你目前处于封禁状态');
            return $this->redirect('/site/block');
        }
        $data['user_id'] = $user_id;
        //获取所有可用的活动类型
        $data['typelist'] = ActivityTypeService::GetList();
        return $this->render('add',['data'=>$data]);
    }

}