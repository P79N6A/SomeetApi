<?php
namespace app\common\service;
use app\common\service\BaseService;
use app\models\AppPush;
use yii\web\Response;
use Yii;
use yii\db\ActiveQuery;
use app\component\CommonFunction;
class LarkService extends BaseService{
	/**	
	 * 获取token值
	 */
	public static function getToken(){
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
	}
	/**
	 * 发送消息到群
	 */
	public function sendToGroup($data){
		$url = 'https://open.feishu.cn/open-apis/message/v3/send/';
		$token = LarkService::GetToken();
		$headers = array("Authorization:Bearer ".$token,'Content-type: application/json');
		if(empty($data)){
			$data = [
				'open_chat_id'=>'oc_99674dcbea3fa8714a1ea498d3376d50',
				"msg_type"=>"text",
				"content"=>["text"=>'嘿嘿']
			];
		}
		$info = CommonFunction::httpRequest($url,'post',$headers,$data);
		return $info;
	}
	/**
	 * 私聊位置
	 */
	public function sendToSingle($data){
		$url = 'https://open.feishu.cn/open-apis/message/v3/send/';
		$token = LarkService::GetToken();
		$headers = array("Authorization:Bearer ".$token,'Content-type: application/json');
		if(empty($data)){
			$data = [
				'open_id'=>'ou_facf44bac1b1ee63bc6106f88de35130',
				"msg_type"=>"text",
				"content"=>["text"=>'嘿嘿']
			];
		}
		$info = CommonFunction::httpRequest($url,'post',$headers,$data);
		return $info;
	}

	public function getLogList(){
		$redis = Yii::$app->redis;
		$redis->set('rootFloder','87cAdRG3W0lyNR53');
		$url = 'https://internal-api.feishu.cn/space/api/explorer/get/?token=87cAdRG3W0lyNR53&need_path=1&rank=0&asc=0&from=message';
		$list = CommonFunction::httpRequest($url,'get',[],[],true);
		$list = json_decode($list,true);
		$data = [];
		if($list['code'] == 0){
			$data = $list['data'];
		}
		//子目录
		$childFloder = [];
		$create_time =[];
		if(isset($data['entities']['nodes'])){
			foreach($data['entities']['nodes'] as $key=>$row){
				// array_push($childFloder,$key);
				$create_time[$key]=$row['create_time'];
			}
			array_multisort($create_time,SORT_DESC,$data['entities']['nodes']);
			$index = 1;
			foreach ($data['entities']['nodes'] as $key => $value) {
				if($value['type'] !=0){
					continue;
				}
				$childFloder[$key] = $value['create_time'];
				//获取该目录下的所有文件
				$url = 'https://internal-api.feishu.cn/space/api/explorer/get/?token='.$key.'&need_path=1&rank=0&asc=0&from=message';
				$clist = CommonFunction::httpRequest($url,'get',[],[],true);
				$clist = json_decode($clist,true);
				$cdata = $clist['data'];
				$fileList=[];
				if(count($cdata['entities']['nodes'])>0){
					foreach ($cdata['entities']['nodes'] as $key1 => $value) {
						if($value['type'] == 2){
								$is_exists = AppPush::find()->where(['from_type'=>$value['obj_token']])->exists();
								if($is_exists){
									//检测每个文件是否发送
									continue;
								}
								$fileList['obj_token'] = $value['obj_token'];
								$fileList['name'] = $value['name'];
								$fileList['url'] = $value['url'];
								$fileList['create_time'] = $value['create_time'];
								$redis->lpush('fileList',serialize($fileList));
								$push = new AppPush();
								$push->user_id = 285;
								$push->jiguang_id = '285';
								$push->content = $value['name'];
								$push->from_type = $value['obj_token'];
								$push->created_at = time();
								$push->status = 0;
								if(!$push->save()){
									var_dump($push->getErrors());
								}
						}
					}
					$is_exists = AppPush::find()->where(['from_type'=>$key])->exists();
					if(!$is_exists){
						$floder = new AppPush();
						$floder->user_id = 285;
						$floder->jiguang_id = '285';
						$floder->content = '所属目录';
						$floder->from_type = $key;
						$floder->created_at = time();
						$floder->status = 0;
						if(!$floder->save()){
							var_dump($floder->getErrors());
						}
						$redis->set('child-'.$key,$key);
					}
					
				}
				$index++;
				if($index>5){
					break;
				}
			}
		}
	}
}