<?php
namespace app\controllers;
use Yii;
use app\component\BaseController;
use yii\web\Response;
use app\models\Activity;
use app\models\User;
use app\common\service\SpaceService;
use yii\filters\AccessControl;
use yii\base\ActionFilter;

class SpaceController extends BaseController{
	
	public function behaviors(){
        return [
            'access' => [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'index',
                    'edit',
                    'add'
                ],
            ],
        ];

    }
	/**
     * 活动列表首页
     */
	public function actionIndex(){
        $user_id = Yii::$app->user->id;
        $data['user_id'] = $user_id;
		return $this->render('index',$data);
	}
    /**
     * =添加一个个场地
     */
    public function actionAdd(){
        $this->layout = "view";
        // $user_id = Yii::$app->user->id;
        $user_id = 2961;
        return $this->render('edit',['id'=>0,'user_id'=>$user_id]);
    }
    /**
     * 更新
     */
    public function actionEdit($id=0){
        $this->layout = "view";
        // $user_id = Yii::$app->user->id;
        $user_id = 2961;
        
        return $this->render('edit',['id'=>$id,'user_id'=>$user_id]);
    }
}