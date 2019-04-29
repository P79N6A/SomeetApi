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
                    // 'logout',
                    'login-user',
                    'error',
                    'block'
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
     * 状态异常页面
     */
    public function actionBlock(){
        $this->layout = 'error';
        $session = YIi::$app->session;
        $msg = $session->get('error_msg');
        $session->remove('error_msg'); 
        return $this->render('block',['error_msg'=>$msg]);
    }
    /**
     * 无权查看信息
     */
    public function actionError(){
        $this->layout = 'error';
        $session = YIi::$app->session;
        $msg = $session->get('error_msg');
        $session->remove('error_msg'); 
        return $this->render('403',['error_msg'=>$msg]);
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

        if(!Yii::$app->user->isGuest){
            $user_id = Yii::$app->user->id;
            $role = MemberService::checkRole($user_id);
            if($role['is_admin'] == 1){
               return $this->redirect('/activity/index');
                die;
            }
            if($role['is_founder'] == 1){
                return $this->redirect('/founder/index');
                die;
            }

        }
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

        return $this->redirect('/site/login');
        die;
    }

    /**
     * 处理登录
     */
    public function actionLoginUser(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $data = $request->post();
        if(!isset($data['password']) || !isset($data['username'])){
            return ['status'=>0,'data'=>'登陆失败'];
        }
        $user = User::find()->where(['username'=>$data['username']])->one();
        if($user && isset($user->id) && $user->validatePassword($data['password'],$user->password_hash)){
            $auth = MemberService::checkRole($user->id);
            if(!$auth['is_admin'] && !$auth['is_founder']){
                return ['status'=>0,'data'=>'你没有权限登陆'];
            }
            $user->generateAccessToken();
            $user->last_login_at = time();
            if($user->save()){
                Yii::$app->user->login($user,7200);
                $session->set('access_token',$user->access_token);
                return ['status'=>1,'data'=>'登陆成功','access-token'=>$user->access_token];
            }else{
                return $user->getErrors();
            }
            
            
        }
        return ['status'=>0,'data'=>'登陆失败'];
    }
}
