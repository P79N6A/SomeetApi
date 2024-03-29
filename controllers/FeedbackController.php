<?php
namespace app\controllers;
use Yii;
use app\component\BaseController;
use yii\web\Response;
use app\models\Activity;
use app\models\User;
use yii\filters\AccessControl;
use yii\base\ActionFilter;

class FeedbackController extends BaseController{
	
	public function behaviors(){
        return [
            'access' => [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'index'
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
}