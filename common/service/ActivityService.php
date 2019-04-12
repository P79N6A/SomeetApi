<?php
namespace app\common\service;
use app\common\service\BaseService;
use app\models\Activity;
use yii\web\Response;
use Yii;
use yii\db\ActiveQuery;
use app\component\CommonFunction;
use yii\data\Pagination;
class ActivityService extends BaseService{

	/**
	 * 获取周活动
	 * 历史，预发布
	 */
	public static function getActlist($data=[]){
		$data['status'] = isset($data['status'])?$data['status']:0;
		$data['is_history'] = isset($data['is_history'])?$data['is_history']:0;
		$query = Activity::find()->select(['id','title','created_by','desc','group_code','status','start_time','end_time']);
		// $query = $data['is_history']==0?$query->where("status >8")->andWhere(['>=','start_time',getLastEndTime()]):$query->where("status >8")->andFilterWhere(['between','start_time',getWeekBefore(),getLastEndTime()]);
		switch ($data['status']) {
			case 0:
				if($data['is_history'] == 0){
					$query->where("status >8")->andWhere(['>=','start_time',getLastEndTime()]);
				}else{
					$query->where("status >8")->andFilterWhere(['between','start_time',getWeekBefore(),getLastEndTime()]);
				}
				break;
			
			default:
				$query->where(['status'=>$data['status']]);
				break;
		}
		$count = $query->count();
		$page = new Pagination(['totalCount' => $count,'pageSize'=>'30']);
		$list['data'] = $query->asArray()->offset($page->offset)->limit($page->limit)->all();
		$list['count'] = $count;
		return $list;
	}
}