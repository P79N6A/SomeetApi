<?php
namespace app\modules\back\controllers;


use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use app\component\CommonFunction;
use app\models\Activity;
use app\models\Profile;
use app\models\User;
use app\models\Answer;
use app\models\ActivityBlack;
use app\models\CollectAct;
use app\models\ActivityType;
use app\common\service\MemberService;
use app\models\UserSelectTags;
use app\models\UserIdcardCheck;
use Yii;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\modules\v1\controllers\BaseController;

class MemberController extends BaseController
{
	public $modelClass = 'app\models\Activity';
	public function behaviors(){
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => CompositeAuth::className(),
			'authMethods' => [
				HttpBasicAuth::className(),
				HttpBearerAuth::className(),
				QueryParamAuth::className(),
			],
			//暂时解除限制不需要token就可以访问的方法
			'optional' => [
				'login',
				// 'get-list',
				// 'update-status',
				// 'get-info',
				// 'role-update',
				// 'get-user-search',
				// 'founder-check'
			]
		];
		$behaviors['access'] = [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                	'login',
                    'get-list',
                    'update-status',
                    'get-info',
                    'role-update',
                    'get-user-search',
                    'founder-check'
                ],
            ];
		return $behaviors;
	}

	public function actionGetList(){
		$request = Yii::$app->request;
		$params = $request->get();
		$data =[
			'is_founder'=>isset($params['is_founder'])?$params['is_founder']:0,
			'is_black'=>isset($params['is_black'])?$params['is_black']:0,
			'is_lock'=>isset($params['is_lock'])?$params['is_lock']:0,
			'is_apply'=>isset($params['is_apply'])?$params['is_apply']:0,
			'is_all'=>isset($params['is_all'])?$params['is_all']:0,
			'is_admin'=>isset($params['is_admin'])?$params['is_admin']:0
		];
		$list = MemberService::getList($data);
		return $list;
	}

	/**
	 * 更新用户的状态
	 */
	public function actionUpdateStatus(){
		$data = Yii::$app->request->post();
		if(!isset($data['type']) || !isset($data['status'])){
			return ['status'=>0,'msg'=>'参数故障，无法处理'];
		}
		if(!in_array($data['type'],['black','lock','unblack','unlock'])){
			return ['status'=>0,'msg'=>'操作不当'];
		}
		$res = MemberService::updateStatus($data);
		return $res?[
			'status'=>1,
			'msg'=>'操作成功'
		]:[
			'status'=>0,
			'msg'=>'操作失败'
		];
	}
	/**
	 * 获取单个用户详情
	 */
	public function actionGetInfo(){
		$request = Yii::$app->request;
		$params = $request->post();
		if(!in_array('user_id', array_keys($params))){
			return ['status'=>0,'msg'=>'数据错误'];
		}
		$id = $params['user_id'];
		return MemberService::getInfo($id,['profile','tags','is_admin','is_founder','yellowCard','answers','activity','realname']);
	}
	/**
	 * 授权用户角色
	 */
	public function actionRoleUpdate(){
		$request = Yii::$app->request;
		$data = $request->post();
		if(!isset($data['user_id'])){
			return ['status'=>0,'msg'=>'用户获取失败'];
		}
		$auth = Yii::$app->authManager;
		if($data['type'] == 'founder'){
			$role = $auth->getRole('founder');
		}
		if($data['type'] == 'admin'){
			$role = $auth->getRole('admin');
		}
		if($data['status'] == 'auth'){
			$auth->assign($role,$data['user_id']);
		}else{
			$auth->revoke($role,$data['user_id']);
		}
		return ['status'=>1,'msg'=>'ok'];
	}
	/**
	 * 根据用户的输入搜索发起人信息
	 */
	public function actionGetUserSearch(){
		$request = Yii::$app->request;
		$data =$request->get();
		if(!$data['type'] || !$data['val']){
			return ['status'=>0,'msg'=>'数据操作错误'];
		}
		return MemberService::getUserBySearch($data);
	}

	/**
	 * 发起人审核身份证
	 */
	public function actionFounderCheck(){
		$request = Yii::$app->request;
		$data = $request->post();
		$user_id = Yii::$app->user->id;
		//查询是否存在该发起人的身份审核信息
		$idcheck = UserIdcardCheck::find()->where(['user_id'=>$user_id])->one();
		if(!$idcheck){
				$idcheck = new UserIdcardCheck();
			}
		$transaction = $idcheck->getDb()->beginTransaction();
		try{
			$idcheck->realname = $data['real_name'];
			$idcheck->idcard = $data['idcard'];
			$idcheck->idcards_A = $data['idcard_A'];
			$idcheck->idcards_B = $data['idcard_B'];
			$idcheck->user_id = $user_id;
			$idcheck->created_at = time();
			$idcheck->status = 0;
			if($idcheck->save()){
				return ['status'=>1,'data'=>'更新成功'];
			}
		}catch (\Exception $e){
			$transaction->rollBack();
		    return ['status'=>0,'msg'=>$idcheck->getErrors()];
		}

		return ['status'=>1,'data'=>'更新失败'];
	}
	







}