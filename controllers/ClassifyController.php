<?php
namespace app\controllers;
use Yii;
use app\component\BaseController;
use yii\web\Response;
use app\models\Activity;
use app\models\TagAct;
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
                    'edit',
                    'sub',
                    'sub-index'
                ],
            ],
        ];

    }
    /**
     * 分类首页
     */
    public function actionIndex($id=0){
        $data['id'] = $id;
        return $this->render('index');
    }
    /**
     * 二级分类首页
     */
    public function actionSubIndex($id=0){
        return $this->render('sub-index');
    }
    /**
     * 二级分类修改
     */
    public function actionSub($id=0){
        $this->layout = 'view';
        $data['id'] = $id;
        $child = TagAct::findOne($id);
        //获取该分类的父类详情
        $parent = ActivityTypeService::getView($child->pid,'top');
        return $this->render('sub',['id'=>$id,'p'=>$parent,'c'=>$child]);
    }
    /**
     * 分类编辑
     */
    public function actionEdit($id = 0){
        $this->layout = 'view';
        $child = [];
        if($id){
            $child = ActivityTypeService::getView($id,'top');
        }
        return $this->render('edit',['id'=>$id,'c'=>$child]);
    }
    /**
     * 获取分类详情
     */
    public function actionClassifyView($id = 0,$type='top'){
        if(!$id) return ['status'=>0,'data'=>false];
        $info = ActivityTypeService::getView($id,$type);
        return ['status'=>1,'data'=>$info];
    }
}