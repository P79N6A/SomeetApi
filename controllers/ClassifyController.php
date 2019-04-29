<?php
namespace app\controllers;
use Yii;
use app\component\BaseController;
use yii\web\Response;
use app\models\Activity;
use app\common\service\ActivityService;
use app\common\service\SpaceService;
use app\common\service\ActivityTagService;
use app\models\User;
use app\common\service\MemberService;
use app\common\service\ActivityTypeService;
use yii\filters\AccessControl;
use yii\base\ActionFilter;

class ClassifyController extends BaseController{
	
	public function behaviors(){
        return [
            'access' => [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'index',
                    'edit'
                ],
            ],
        ];

    }
    /**
     * 分类首页
     */
    public function actionIndex(){
        return $this->render('index');
    }

    /**
     * 分类编辑
     */
    public function actionEdit($id = 0){
        $this->layout = 'view';

        return $this->render('edit',['id'=>$id]);
    }
}