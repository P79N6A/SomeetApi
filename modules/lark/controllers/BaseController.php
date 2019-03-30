<?php
namespace app\modules\lark\controllers;

use yii\rest\ActiveController;


class BaseController extends ActiveController{
		public $responseScenario;
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
		public function actions()
		{

			$actions = parent::actions();

			$actions['index']['class'] = 'app\actions\IndexAction';
			$actions['view']['class'] = 'app\actions\ViewAction';
			$actions['create']['class'] = 'app\actions\CreateAction';
			$actions['update']['class'] = 'app\actions\UpdateAction';

			if ($this->responseScenario !== null) {
				$actions['index']['responseScenario'] = $this->responseScenario;
				$actions['view']['responseScenario'] = $this->responseScenario;
				$actions['create']['responseScenario'] = $this->responseScenario;
				$actions['update']['responseScenario'] = $this->responseScenario;
			}

			// 全部的API都手动写出来,然后用权限控制
			unset($actions['delete'], $actions['create'], $actions['index'], $actions['view'], $actions['update']);

			return $actions;
		}
		
		public function behavior(){
			return parent::behavior();
		}
}