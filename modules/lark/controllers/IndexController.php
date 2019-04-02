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
use app\common\service\LarkService;
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
				'send-to-single',
				'chat-bot',
				'get-log-list'
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
					'send-to-single',
					'chat-bot',
					'get-log-list'
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
					'send-to-single'=>['GET'],
					'chat-bot'=>['GET'],
					'get-log-list'=>['GET']
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
		$data =trim(file_get_contents('php://input'),chr(239).chr(187).chr(191));
		$data = json_decode($data, true);
		if(isset($data['challenge'])) return Yii::$app->formatter->asRaw(['challenge'=>$data['challenge']]);
		$event = $data['event'];
		$type = $event['type'];
		$room_id = $event['open_chat_id'];
		$send_user_id = $event['user_open_id'];
		$message_id = $event['open_message_id'];
		$chat_type = $event['chat_type'];
		$text = addslashes($event['text']);
		file_put_contents('/var/www/html/web/text.txt',$text);
		$is_mention = $event['is_mention'];
		$uuid = $event['uuid'];
		$uuid = explode('ou_',$send_user_id)[1];
		switch($type){
			case 'message':
			if($is_mention){
				$t = strpos($text,"</at>");
				$text = trim(substr($text,$t+5));
				if($text == '夸夸大家'){
					$arr = ['你们真棒啊','大兄弟666啊','牛逼，同志们','不，我不想夸'];
					$text = $arr[array_rand($arr,1)];
					$msg = [
						'msg'=>$text
					];
				}else{
					$msg = self::actionChatBot($uuid,$text);
				}
				if(!isset($msg['msg'])){
					$msg['msg'] = 'Sorry,我现在还不知道怎么回答你啦';
				}
				$data=[
					'open_chat_id'=>$room_id,
					'msg_type'=>'text',
					'content'=>["text"=>$msg['msg']],
					// 'root_id'=>$message_id
				];
				return LarkService::sendToGroup($data);
			}
			if($chat_type == 'private'){
				$msg = self::actionChatBot($uuid,$text);
				if(!isset($msg['msg'])){
					$msg['msg'] = 'Sorry,我现在还不知道怎么回答你啦';
				}
				$data=[
					'open_id'=>$send_user_id,
					'msg_type'=>'text',
					'content'=>["text"=>$msg['msg']]
				];
				return LarkService::sendToGroup($data);
			}
			break;
		}
	}
	
	
	
	public function actionGetMember(){
		$url = 'https://open.feishu.cn/open-apis/chat/v3/info/';
		$token = LarkService::getToken();
		$headers = array("Authorization:Bearer ".$token,'Content-type: application/json');
		$data['open_chat_id'] = 'oc_99674dcbea3fa8714a1ea498d3376d50';
		$info = CommonFunction::httpRequest($url,'post',$headers,$data);
		echo '<pre>';
		var_dump($info);
		exit;
	}
	
	
	/**	
	 * 获取群列表
	 */
	public function actionGetGroupList(){
		$url ='https://open.feishu.cn/open-apis/chat/v3/list/';
		$token = LarkService::getToken();
		$headers = array("Authorization:Bearer ".$token,'Content-type: application/json');
		$data['page']=1;
		$list = CommonFunction::httpRequest($url,'post',$headers,$data);
		echo '<pre>';
		var_dump($list);
		exit;
	}
	
	/**	
	 * 聊天机器人
	 */
	public function actionChatBot($user_id='1',$text='你好啊'){
		$url = 'http://openapi.tuling123.com/openapi/api/v2';
		$data = [
			'perception'=>[
				'inputText'=>[
					"text"=>$text
				],
				'selfInfo'=>[
					'location'=>[
						"city"=>'北京'
					]
				]
			],
			'userInfo'=>[
				'apiKey'=>'5fa3228440e74c50ae0786612ce8b7f7',
				'userId'=>$user_id
			]
		];
		$headers = array('Content-type: application/json');
		$info = CommonFunction::httpRequest($url,'post',$headers,$data);
		$res = json_decode($info,true);
		$erroCode = [5000,6000,4000,4001,4002,4003,4005,4007,4100,4200,4300,4400,4500,46000,4602,7002,8008];
		if(in_array(intval($res['intent']['code']),$erroCode)){
			return [
				'msg'=>'哎呀，我系统出问题啦，不知道说什么好啦'.$res['intent']['code']
			];
		}else{
			$data = $res['results'];
			if($data[0]['resultType'] == 'text'){
				$text = $data[0]['values']['text'];
				return [
					'msg'=>$text
				];
			}else{
				return [
					'msg'=>'我现在会的还不是很多啦，以后再问吧，嘿嘿'
				];
			}
			
		}
	}
	
	/**	
	 * 获取所有的日志
	 */
	public function actionGetLogList(){
		$redis = Yii::$app->redis;
		$res = LarkService::getLogList();
		echo '<pre>';
		print_r($redis->lrange('fileList',0,-1));
		die;
	}
}