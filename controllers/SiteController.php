<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\User;
use app\component\BaseController;

class SiteController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'login',
                ],
            ],
        ];

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
            // $admin = User::findOne($uid);
            // Yii::$app->user->login($admin);
            // if(Yii::$app->user->getId()){
            //     return true;
            // }
            // return false;
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
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
	
	public function actionSay($message = 'hello'){
		return $this->render('say',['message' => $message]);
	}
}
