<?php
namespace app\controllers;
use Yii;
use app\component\BaseController;
use yii\web\Response;
use app\models\Activity;
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
                    'add'
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
}