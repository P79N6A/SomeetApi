<?php
namespace app\common\service;
use app\common\service\BaseService;
use app\models\Activity;
use app\models\TagAct;
use app\models\ActivityType;
use yii\web\Response;
use Yii;
use yii\db\ActiveQuery;
use app\component\CommonFunction;
use yii\data\Pagination;
class ActivityTagService extends BaseService{
	/**
	 * 获取当前类型的标签
	 */
	public static function getTags($type_id){
		$tags = TagAct::find()
				->select(['name','id','pid'])
                ->where(['pid' => $type_id])
                ->asArray()
                ->all();
        return $tags;
	}
}