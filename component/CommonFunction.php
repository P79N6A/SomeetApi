<?php
namespace app\component;

use app\models\UserSelectTags;
use yii\base\Component;

class CommonFunction extends Component
{
	/**
	 * 获取单独用户的标`签
	 */
	public static function getUserTags(array $search =[],array $select =[],$limit = 0){
		$model = UserSelectTags::find();
		if(is_array($search) && !empty($search)){
			$model->where($where)->asArray();
			
		}
		if(is_array($select) && !empty($select)){
			$model->select($select);	
		}
		if($limit !==0){
			$model->limit($limit);
		}
		return $model->all();
	}
	
	/**	
	 * 模拟请求
	 */
	public static function httpRequest($url,$method='get',$headers=[],$data=[]){
		// 1. 初始化
		$ch = curl_init();
		// 2. 设置选项，包括URL
		curl_setopt($ch,CURLOPT_URL,$url);
		//设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//设置头文件的信息作为数据流输出
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		if($method == 'post'){
			//设置post方式提交
			curl_setopt($ch, CURLOPT_POST, 1);
			//设置post数据
			
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		}
		// 3. 执行并获取HTML文档内容
		$result = curl_exec($ch);
		if($result === FALSE ){
			return curl_error($ch);
		}
		// 4. 释放curl句柄
		curl_close($ch);
		return $result;
	}
}