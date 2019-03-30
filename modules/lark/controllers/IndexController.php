<?php
namespace app\modules\lark\controllers;


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
use app\models\UserSelectTags;
use Yii;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\modules\lark\controllers\BaseController;

class IndexController extends BaseController
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
			//暂时解除限制或者未登录就可以访问的方法
			'optional' => [
				'token',
				'get-token',
				'get-group-list',
				'send-to-group',
				'get-member'
			]
		];
		$behaviors['access'] = [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'token',
					'get-token',
					'get-group-list',
					'send-to-group',
					'get-member'
                ],
            ];
		$behaviors['verbs'] = [
                'class' => VerbFilter::className(),
                'actions' => [
                    'token' => ['POST'],
					'get-token'=>['GET'],
					'get-group-list'=>['GET'],
					'send-to-group'=>['GET'],
					'get-member'=>['GET']
                ],
            ];
		return $behaviors;
	}
	/**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if ($action->id == 'token') {
            // 当用户完成交易后 Ping++ 会以 POST 方式把数据发送到你的 hook 地址
            // 所以这时候需要临时关闭掉 Yii 的 CSRF 验证
            Yii::$app->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
	public function actionToken(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$request = Yii::$app->request;
		if(!$request->isPost){
			return false;
		}
		$data = $request->getRawBody();
		file_put_contents('/var/www/html/web/data.text',$data);
		$data = json_decode($data,true);
		if(isset($data['challenge'])) return Yii::$app->formatter->asRaw(['challenge'=>$data['challenge']]);
		
	}
	
	public function actionSendToGroup(){
		$url = 'https://open.feishu.cn/open-apis/message/v3/send/';
		$token = self::actionGetToken();
		$headers = array("Authorization:Bearer ".$token,'Content-type: application/json');
		$data = [
			'open_chat_id'=>'oc_99674dcbea3fa8714a1ea498d3376d50',
			"msg_type"=>"text",
			"content"=>["text"=>"是的啊，我是机器人啊"]
		];
		$info = CommonFunction::httpRequest($url,'post',$headers,$data);
		echo '<pre>';
		var_dump($info);
		exit;
	}
	
	public function actionGetMember(){
		$url = 'https://open.feishu.cn/open-apis/chat/v3/info/';
		$token = self::actionGetToken();
		$headers = array("Authorization:Bearer ".$token,'Content-type: application/json');
		$data['open_chat_id'] = 'oc_99674dcbea3fa8714a1ea498d3376d50';
		$info = CommonFunction::httpRequest($url,'post',$headers,$data);
		echo '<pre>';
		var_dump($info);
		exit;
	}
	
	/**	
	 * 获取token值
	 */
	public function actionGetToken(){
		$data = '{"app_access_token":"t-8664db79888680b8d0e668ec2397829248322af1","code":0,"expire":7200,"tenant_access_token":"t-8664db79888680b8d0e668ec2397829248322af1"}';
		return json_decode($data,true)['app_access_token'];
		$url = 'https://open.feishu.cn/open-apis/auth/v3/app_access_token/internal';
		$headers = array('Content-type: application/json');
		$data = array(
			"app_id" => "cli_9c14a73e0a381108",
			"app_secret" => "tx48Duv1luptHFHHSeKrjfpPhFQeYGeY"
			);
		$token = CommonFunction::httpRequest($url,'post',$headers,$data);
		echo '<pre>';
		var_dump($token);
		exit;
	}
	/**	
	 * 获取群列表
	 */
	public function actionGetGroupList(){
		$data ='{"chats":[{"id":"oc_99674dcbea3fa8714a1ea498d3376d50","name":"Someet","owner_id":"ou_e1e40c24b73f9be06be9d2b379908d8b"}],"code":0,"has_more":false}';
		return json_decode($data,true);
		$url ='https://open.feishu.cn/open-apis/chat/v3/list/';
		$token = self::actionGetToken();
		$headers = array("Authorization:Bearer ".$token,'Content-type: application/json');
		$data['page']=1;
		$list = CommonFunction::httpRequest($url,'post',$headers,$data);
		echo '<pre>';
		var_dump($list);
		exit;
	}
}