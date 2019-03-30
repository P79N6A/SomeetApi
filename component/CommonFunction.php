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
}