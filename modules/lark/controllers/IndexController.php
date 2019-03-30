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
				'get-member',
				'send-to-single'
			]
		];
		$behaviors['access'] = [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'token',
					'get-token',
					'get-group-list',
					'send-to-group',
					'get-member',
					'send-to-single'
                ],
            ];
		$behaviors['verbs'] = [
                'class' => VerbFilter::className(),
                'actions' => [
                    'token' => ['POST'],
					'get-token'=>['GET'],
					'get-group-list'=>['GET'],
					'send-to-group'=>['GET'],
					'get-member'=>['GET'],
					'send-to-single'=>['GET']
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
		file_put_contents('/var/www/html/web/rawData.txt',$data);
		$data = json_decode("'".$data."'",true);
		file_put_contents('/var/www/html/web/data.txt',$data);
		if(isset($data['challenge'])) return Yii::$app->formatter->asRaw(['challenge'=>$data['challenge']]);
		// $data = '{"uuid":"001ac9e6acfbb36e138f02ee60d11508","event":{"type":"message","root_id":"","parent_id":"","open_chat_id":"oc_99674dcbea3fa8714a1ea498d3376d50","msg_type":"text","user_open_id":"ou_facf44bac1b1ee63bc6106f88de35130","open_id":"ou_facf44bac1b1ee63bc6106f88de35130","open_message_id":"om_5bf2b254998ff412a711e97e885296d3","is_mention":true,"chat_type":"group","text":"\u003cat open_id=\"ou_590c1ff814a495b0d3841d6223806160\"\u003e@Someet机器人\u003c/at\u003e ?","user_agent":"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Lark/1.17.0 Chrome/58.0.3029.110 Electron/1.7.9 Safari/537.36"},"token":"Xf8AevWWSWR090cisewrlg8ViiLcw4n7","ts":"1553942465.686809","type":"event_callback"}';
// 		$data = json_decode($data,true);
		$event = $data['event'];
		file_put_contents('/var/www/html/web/events.txt',$event);
		$type = $event['type'];
		$room_id = $event['open_chat_id'];
		$send_user_id = $event['user_open_id'];
		$message_id = $event['open_message_id'];
		$chat_type = $event['chat_type'];
		$text = $event['text'];
		$is_mention = $event['is_mention'];
		switch($type){
			case 'message':
			if($is_mention){
				$data=[
					'open_chat_id'=>$room_id,
					'msg_type'=>'text',
					'content'=>["text"=>'Sorry,我现在还不知道怎么回答你啦'],
					'root_id'=>$message_id
				];
				return self::actionSendToGroup($data);
			}
			break;
		}
	}
	
	public function actionSendToGroup($data){
		$url = 'https://open.feishu.cn/open-apis/message/v3/send/';
		$token = self::actionGetToken();
		$headers = array("Authorization:Bearer ".$token,'Content-type: application/json');
		if(empty($data)){
			$data = [
				'open_chat_id'=>'oc_99674dcbea3fa8714a1ea498d3376d50',
				"msg_type"=>"text",
				"content"=>["text"=>'嘿嘿']
			];
		}
		$info = CommonFunction::httpRequest($url,'post',$headers,$data);
		echo '<pre>';
		var_dump($info);
		exit;
	}
	public function actionSendToSingle($data){
		$url = 'https://open.feishu.cn/open-apis/message/v3/send/';
		$token = self::actionGetToken();
		$headers = array("Authorization:Bearer ".$token,'Content-type: application/json');
		if(empty($data)){
			$data = [
				'open_id'=>'ou_facf44bac1b1ee63bc6106f88de35130',
				"msg_type"=>"text",
				"content"=>["text"=>'嘿嘿']
			];
		}
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
		$cache = Yii::$app->cache; 
		$token = $cache->get('app_access_token');
		if($token){
			return $token;
		}
// 		$data = '{"app_access_token":"t-8664db79888680b8d0e668ec2397829248322af1","code":0,"expire":7200,"tenant_access_token":"t-8664db79888680b8d0e668ec2397829248322af1"}';
// 		return json_decode($data,true)['app_access_token'];
		$url = 'https://open.feishu.cn/open-apis/auth/v3/app_access_token/internal';
		$headers = array('Content-type: application/json');
		$data = array(
			"app_id" => "cli_9c14a73e0a381108",
			"app_secret" => "tx48Duv1luptHFHHSeKrjfpPhFQeYGeY"
			);
		$token = CommonFunction::httpRequest($url,'post',$headers,$data);
		$rawData = json_decode($token,true);
		$token = $rawData['app_access_token'];
		$cache->set('app_access_token',$token,7200);
		return $cache->get('app_access_token');
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