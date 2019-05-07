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
class ActivityTypeService extends BaseService{

	/**
	 * 获取所有可用的活动新类型
	 */
	public static function GetList(){
		$city_id = getCityId();
        $types = ActivityType::find()
            ->where(['city_id' => $city_id])
            ->select(['id','name','img'])
            ->orderBy([
                'display_order' => SORT_ASC,
                'id' => SORT_DESC,
            ])
            ->asArray()
            ->all();
        $weekWhere = ['>', 'start_time', getLastEndTime()];
        for ($i = 0; $i < count($types); ++$i) {
            $types[$i]['type_number'] = Activity::find()
                    ->where(
                            ['and',
                                ['in', 'status', [
                                    Activity::STATUS_DRAFT,
                                    Activity::STATUS_RELEASE,
                                    Activity::STATUS_PREVENT,
                                    Activity::STATUS_SHUT,
                                    Activity::STATUS_CANCEL,
                                    Activity::STATUS_PASS,

                                ]],
                                ['=', 'type_id', $types[$i]['id']],
                                $weekWhere,
                            ]
                        )
                    ->count();
        }

        return $types;
	}
	/**
	 * 获取父类
	 */
	public static function getTopList(){
		$list = ActivityType::find()->select(['name','id'])->asArray()->all();
		return $list;
	}
	/**
	 * 
	 */
	/**
	 * 获取类型列表
	 */
	public static function getListByPage($data){
		if($data['is_sub'] == 0){
			$query = ActivityType::find()->select(['id','name','share_desc','city','is_app','status']);
			if($data['type'] != 'all'){
				$query->where(['is_app'=>$data['type'],'status'=>ActivityType::STATUS_NORMAL]);
			}else{
				$query->where(['is_app'=>$data['type']]);
			}
		}else{
			$query = TagAct::find()->select(['id','name','pid','order','status']);
			if($data['pid'] != 0){
				$query->where(['pid'=>$data['pid']]);
			}
		}
		$count = $query->count();
		$page = new Pagination(['totalCount' => $count,'pageSize'=>$data['limit']]);
		$list['data'] = $query->asArray()->offset($page->offset)->limit($page->limit)->all();
		$list['count'] = $count;
		return $list;
	}
	/**
	 * 更新状态
	 */
	/**
	 * 更新用户的状态
	 */
	public static function updateStatus($data){
		switch ($data['type']) {
			// 拉黑
			case 'show':
				ActivityType::updateAll(['status'=>ActivityType::STATUS_NORMAL],['id'=>$data['id']]);
				$user = ActivityType::find()->select(['status'])->where(['id'=>$data['id']])->one();
				return $user && $user->status == ActivityType::STATUS_NORMAL ?true:false;
				break;
			// 封禁
			case 'hide':
				ActivityType::updateAll(['status'=>ActivityType::STATUS_HIDDEN],['id'=>$data['id']]);
				$user = ActivityType::find()->select(['status'])->where(['id'=>$data['id']])->one();
				return $user && $user->status == ActivityType::STATUS_HIDDEN ?true:false;
				break;
		}
	}
	/**
	 * 更新用户的状态
	 */
	public static function updateSubStatus($data){
		switch ($data['type']) {
			// 拉黑
			case 'show':
				TagAct::updateAll(['status'=>ActivityType::STATUS_NORMAL],['id'=>$data['id']]);
				$user = TagAct::find()->select(['status'])->where(['id'=>$data['id']])->one();
				return $user && $user->status == ActivityType::STATUS_NORMAL ?true:false;
				break;
			// 封禁
			case 'hide':
				TagAct::updateAll(['status'=>ActivityType::STATUS_HIDDEN],['id'=>$data['id']]);
				$user = TagAct::find()->select(['status'])->where(['id'=>$data['id']])->one();
				return $user && $user->status == ActivityType::STATUS_HIDDEN ?true:false;
				break;
		}
	}
	/**
	 * 添加分类
	 */
	public static function createTop()
    {
        $request = Yii::$app->getRequest();
        $data = $request->post();
        $data['city_id'] = getCityId();
        $data['city'] = getCity();
        $data['display_order'] = 99;
        unset($data['file']);
        if(!$data['id']) unset($data['id']);
        $model = new ActivityType();
        if($data['id']){
        	$model = ActivityType::findOne($data['id']);
        }
        if ($model->load($data, '') && $model->save()) {
            return ['status'=>1,'data'=>'ok'];
        } elseif ($model->hasErrors()) {
            $errors = $model->getFirstErrors();
            return $errors;
        } else {
            return ['status'=>0,'data'=>'error'];
        }
    }
    /**
	 * 添加分类
	 */
	public static function createSub()
    {
        $request = Yii::$app->getRequest();
        $data = $request->post();
        $model = new TagAct();
        if(!$data['id']) unset($data['id']);
        $model = new TagAct();
        if($data['id']){
        	$model = TagAct::findOne($data['id']);
        }
        if ($model->load($data, '') && $model->save()) {
            return ['status'=>1,'data'=>'ok'];
        } elseif ($model->hasErrors()) {
            $errors = $model->getFirstErrors();
            return $errors;
        } else {
            return ['status'=>0,'data'=>'error'];
        }
    }
    /**
     * 获取详情
     */
    public static function getView($id,$type){
    	$info = false;
    	if($type == 'sub'){
    		$info = TagAct::findOne($id);
    	}
    	if($type=='top'){
    		$info = ActivityType::findOne($id);
    	}
    	return $info;
    }
}