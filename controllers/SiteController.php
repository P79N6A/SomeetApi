<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\User;
use app\component\BaseController;
use app\common\service\MemberService;

class SiteController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'login',
                    'login-user'
                ],
            ],
        ];

    }
    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionSetRole(){
        $auth = Yii::$app->authManager;
        $role = $auth->createRole('author');
        $role->description = 'author';
        $auth->add($role);
        return $role;
    }
    public function actionGetRole(){
        $auth = Yii::$app->authManager;
        $roles = $auth->getPermission('/basic/filter/index');
        echo '<pre>';
        var_dump($roles);
        die;
    }
    public function actionAddPer($uid=1){
        $auth = Yii::$app->authManager;
        $per = $auth->getPermission('/basic/filter/index');
        $role = $auth->getRole('author');
        return $auth->addChild($role,$per);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin($uid=1)
    {

        $request = Yii::$app->request;
        if(!$request->isPost){
            return $this->renderpartial('login');
        }else{
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $data = $request->post();
            return intval(User::checkUser($data));
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return Yii::$app->user->getId();
        die;
    }

    /**
     * 处理登录
     */
    public function actionLoginUser(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $data = $request->post();
        if(!isset($data['password']) || !isset($data['username'])){
            return ['status'=>0,'data'=>'登陆失败'];
        }
        $user = User::find()->where(['username'=>$data['username']])->one();
        if($user->id && $user->validatePassword($data['password'],$user->password_hash)){
            $auth = MemberService::checkRole($user->id);
            if(!$auth['is_admin'] && !$auth['is_founder']){
                return ['status'=>0,'data'=>'你没有权限登陆'];
            }
            $user->generateAccessToken();
            $user->last_login_at = time();
            $user->save();
            Yii::$app->user->login($user,7200);
            return ['status'=>1,'data'=>'登陆成功','access-token'=>$user->access_token];
        }
        return ['status'=>0,'data'=>'登陆失败'];
    }
}
