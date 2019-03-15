<?php
namespace app\modules\v1\controllers;

use yii\rest\ActiveController;


class BaseController extends ActiveController{
		
		/**
		 * 取消session登录装填
		 */
		public function init()
		{
			parent::init();
			\Yii::$app->user->enableSession = false;
		}
		/**	
		 * 注销默认的restapi 动作，手动控制并添加权限验证
		 */
		public function actions(){
			$actions = parent::actions();
			unset($actions['views'],$actions['index'],$actions['create'],$actions['update']);
			return $actions;
		}
		
		public function behavior(){
			return parent::behavior();
		}
}