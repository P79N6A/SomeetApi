<?php
namespace app\controllers;
use Yii;
use app\component\BaseController;
use yii\web\Response;
use app\models\Activity;
use app\models\User;

class FilterController extends BaseController
{
	public function behaviors(){
        return [
            'access' => [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    // 'index',
                ],
            ],
        ];

	}

	public function actionIndex(){
		echo password_hash('adminadmin',1);
		// var_dump(Yii::$app->user->can('createPost'));
		die;
	}
}