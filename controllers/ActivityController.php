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
        $behaviors = parent::behaviors();
        $behaviors['access']=[
            //登录用户和非登录用户的权限简单验证
            'class' => AccessControl::className(),
            'rules' =>[
                [
                    'allow' => true,//是否允许访问
                    'actions' => ['index'],//允许访问的控制器
                    'roles' => ['@'],//访问角色，只有@ 和 ？
                ]
            ]
        ];
		return $behaviors;

	}
	
	public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }
	
	public function actionIndex(){
		return $this->render('index');
	}
    public function actionLogin(){
        echo "this is login page";
        die;
    }
	public function actionAuth($client=null){
		echo $client;
		die;
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