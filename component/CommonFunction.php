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
	public static function httpRequest($url,$method='get',$headers=[],$data=[],$isCookie=false){
		// 1. 初始化
		$ch = curl_init();
		// 2. 设置选项，包括URL
		curl_setopt($ch,CURLOPT_URL,$url);
		//设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//设置头文件的信息作为数据流输出
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		if($method == 'post'){
			//设置post方式提交
			curl_setopt($ch, CURLOPT_POST, 1);
			//设置post数据
			
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		}
		if($isCookie){
			$cookie_file='/var/www/html/web/mycookie.txt';
			if(!file_exists($cookie_file)){
			    $fp = fopen($cookie_file,'w+');
			    fclose($fp);
			}
			$cookie = file_get_contents($cookie_file);
			curl_setopt($ch,CURLOPT_COOKIE,$cookie);
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
	//将内容进行UNICODE编码，编码后的内容格式：\u56fe\u7247 （原始：图片）
	function unicode_encode($name)
	{
		$name = iconv('UTF-8', 'UCS-2', $name);
		$len = strlen($name);
		$str = '';
		for ($i = 0; $i < $len - 1; $i = $i + 2)
		{
			$c = $name[$i];
			$c2 = $name[$i + 1];
			if (ord($c) > 0)
			{    // 两个字节的文字
				$str .= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
			}
			else
			{
				$str .= $c2;
			}
		}
		return $str;
	}
	 
	// 将UNICODE编码后的内容进行解码，编码后的内容格式：\u56fe\u7247 （原始：图片）
	function unicode_decode($name)
	{
		// 转换编码，将Unicode编码转换成可以浏览的utf-8编码
		$pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
		preg_match_all($pattern, $name, $matches);
		if (!empty($matches))
		{
			$name = '';
			for ($j = 0; $j < count($matches[0]); $j++)
			{
				$str = $matches[0][$j];
				if (strpos($str, '\\u') === 0)
				{
					$code = base_convert(substr($str, 2, 2), 16, 10);
					$code2 = base_convert(substr($str, 4), 16, 10);
					$c = chr($code).chr($code2);
					$c = iconv('UCS-2', 'UTF-8', $c);
					$name .= $c;
				}
				else
				{
					$name .= $str;
				}
			}
		}
		return $name;
	}
}