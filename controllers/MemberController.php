<?php
namespace app\controllers;
use Yii;
use app\component\BaseController;
use yii\web\Response;
use app\models\Activity;
use app\models\User;
use app\common\service\MemberService;
use yii\filters\AccessControl;
use yii\base\ActionFilter;

class MemberController extends BaseController{
	
	public function behaviors(){
        return [
            'access' => [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    // 'index',
                    // 'view',
                    // 'login'
                ],
            ],
        ];

    }
	/**
     * 活动列表首页
     */
	public function actionIndex(){
		return $this->render('index');
	}

    /**
     * 用户详情信息
     */
    public function actionView($id){
        $this->layout = "view";
        $data = MemberService::getInfo($id,['profile','tags','is_admin','is_founder','yellowCard','answers','activity']);
        return $this->render('view',['data'=>$data]);
    }
    
}