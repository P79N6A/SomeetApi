<?php
namespace app\common\service;
use app\common\service\BaseService;
use app\models\Activity;
use app\models\ActivityType;
use app\models\ActivityTag;
use app\models\RTagActivity;
use yii\web\Response;
use Yii;
use yii\db\ActiveQuery;
use app\component\CommonFunction;
use yii\data\Pagination;
class ClassifyService extends BaseService{
	/**
	 * 获取类型列表
	 */
	public static function getList($data){
		$query = ActivityType::find()->select(['id','name','share_desc','city','is_app','status']);
		if($data['type'] != 'all'){
			$query->where(['is_app'=>$data['type'],'status'=>ActivityType::STATUS_NORMAL]);
		}else{
			$query->where(['status'=>ActivityType::STATUS_NORMAL]);
		}
		$count = $query->count();
		$page = new Pagination(['totalCount' => $count,'pageSize'=>$data['limit']]);
		$list['data'] = $query->asArray()->offset($page->offset)->limit($page->limit)->all();
		$list['count'] = $count;
		return $list;
	}
}