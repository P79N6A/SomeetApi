<?php
namespace app\common\service;
use app\common\service\BaseService;
use app\common\service\QuestionService;
use app\models\Activity;
use app\models\Question;
use app\models\User;
use app\models\FounderSpaceSpot;
use app\models\SpaceSpot;
use app\models\QuestionItem;
use app\models\ActivityAlbum;
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
		$data['status'] = isset($data['status']) && $data['status']?$data['status']:0;
		$data['is_history'] = isset($data['is_history'])?$data['is_history']:0;
		$query = Activity::find()->select(['id','title','created_by','desc','group_code','status','start_time','end_time','reject_reason'])->orderBy("id desc");
		switch ($data['status']) {
			case 0:
				if($data['is_history'] == 0){
					$query->where("status >= 8")->andWhere(['>=','start_time',getLastEndTime()]);
				}else{
					// $query->where("status >8")->andFilterWhere(['between','start_time',getWeekBefore(),getLastEndTime()]);
					$query->andWhere(['<','start_time',getLastEndTime()]);
				}
				break;
			case 15:
				if($data['is_history'] == 0){
					$query->where("status >= 8")->andWhere(['>=','start_time',getLastEndTime()]);
				}else{
					// $query->where("status >8")->andFilterWhere(['between','start_time',getWeekBefore(),getLastEndTime()]);
					$query->where("status = ".Activity::STATUS_PREVENT)->andWhere(['<','start_time',getLastEndTime()]);
				}
				break;
			case 12 || 3 || 8:
				$query->where(['status'=>$data['status']]);
				break;
			default:
				if($data['is_history'] == 0){
					$query->where(['status'=>$data['status']])->andWhere(['>=','start_time',getLastEndTime()]);
				}else{
					$query->where(['status'=>$data['status']]);
				}
				break;
		}
		if(isset($data['user_id'])){
			$query->andWhere(['created_by'=>$data['user_id']]);
		}
		$count = $query->count();
		$page = new Pagination(['totalCount' => $count,'pageSize'=>$data['limit']]);
		$list['data'] = $query->asArray()->offset($page->offset)->limit($page->limit)->all();
		$list['count'] = $count;
		return $list;
	}

	/**
	 * 获取活动系列
	 */
	public static function getSequence($user_id){
		$activity = Activity::find()
					->select(['title','sequence_id','start_time','id','end_time','created_by'])
                    ->where(
                        ['and',
                            ['created_by' => $user_id],
                            ['>', 'sequence_id', 0],
                        ]
                    )
                    ->groupBy('sequence_id')
                    ->asArray()
                    ->all();
        $activity2 = Activity::find()
        			->select(['title','sequence_id','start_time','id','end_time','created_by'])
                    ->where(
                        ['and',
                            ['created_by' => $user_id],
                            ['=', 'sequence_id', 0],
                        ]
                    )
                    ->asArray()
                    ->all();
        $activities = array_merge($activity, $activity2);

        for ($i = 0; $i < count($activities); ++$i) {
            $sequence_title = $activities[$i]['sequence_id'] > 0 ? '（系列'.$activities[$i]['sequence_id'].')' : '';
            $activities[$i]['title'] = $activities[$i]['title'].$sequence_title;
            $activities[$i]['start_time'] = date('Y-m-d H:i', $activities[$i]['start_time']);
            $activities[$i]['end_time'] = date('Y-m-d H:i', $activities[$i]['end_time']);
        }

        return $activities;
	}
	/**
	 * 创建一个新活动
	 */
	public static function createAct($data){
		$data['start_time'] = strtotime($data['start_time']);
		$data['end_time'] = strtotime($data['end_time']);
		$data['group_code'] = 'http://img.someet.cc/FpyzpZ09e26yoFnwIy3LlYqwmVCk';
		//活动流程
		if(isset($data['review']) && $data['review'])  $data['review'] = serialize($data['review']);
		//注意事项
		if(isset($data['field6']) && $data['field6'])  $data['field6'] = serialize($data['field6']);
		// tips
		if(isset($data['field2']) && $data['field2'])  $data['field2'] = serialize($data['field2']);
		// 嘉宾和头像
		if(isset($data['field7']) && $data['field7'])  $data['field7'] = serialize($data['field7']);
		// 联合发起人
		if(isset($data['co_founder1']) && $data['co_founder1']) $data['is_rfounder'] = 1;
		
		if($data['haveGuest']) $data['is_rfounder'] = 1;

		$data['detail_header'] = serialize([$data['header_title'],$data['header_people']]);

		//活动图片
		$actImg = isset($data['actImg'])?$data['actImg']:[];

		//获取场地
		if($data['space_spot_id']){
			$space = SpaceService::getSpace($data['space_spot_id']);
			if($space){
				$data['address'] = $space['address']?$space['address']:'未设置';
				$data['area'] = $space['area']?$space['area']:'未设置';
				$data['longitude'] = $space['longitude']?$space['longitude']:0;
				$data['latitude'] = $space['latitude']?$space['latitude']:0;
			}
		}
		//设置问题
		$question = $data['question'];

		$data['sequence_id'] = isset($data['sequence_id'])?$data['sequence_id']:0;

		$model = new Activity();
		// $model->is_new = 1;
		//如果是修改活动则aid 不能为零
		$aid = 0;
		$aid = isset($data['aid'])?$data['aid']:0;
		$data['status'] = Activity::STATUS_CHECK;
		if($aid >0){
			return self::updateAct($aid,$data)?['status'=>1,'msg'=>'ok']:['status'=>0,'msg'=>'error'];
		}
		unset($data['file']);
		unset($data['_csrf']);
		unset($data['haveGuest']);
		unset($data['header_title']);
		unset($data['header_people']);
		unset($data['actImg']);
		unset($data['question']);
		unset($data['aid']);
		//赋值
		foreach ($data as $key => $value) {
			$model->$key = $value;
		}
		if($model->save()){
			if(!empty($question)){
				if($aid == 0){
					QuestionService::addQuestion($model->id,$question);
				}else{
					QuestionService::editQuestion($model->id,$question);
				}
			}
			//保存图片
			if(!empty($actImg)){
				foreach ($actImg as $row) {
					$actImg = new ActivityAlbum();
					$actImg->activity_id = $model->id;
					$actImg->img = $row;
					$actImg->save();
				}
			}
			return ['status'=>1,'msg'=>'ok'];
		}else{
			return ['status'=>0,'msg'=>$model->getErrors()];
		}
		
	}
	/**
	 * 修改活动详情
	 */
	public static function updateAct($id,$data){
		$model = Activity::findOne($id);
		//修改标题
		if($data['title'] != $model->title){
			$model->title = $data['title'];
		}
		//修改副标题
		if($data['desc'] != $model->desc){
			$model->desc = $data['desc'];
		}
		//修改文案
		if($data['content'] != $model->content){
			$model->content = $data['content'];
		}
		//修改头图
		if($data['poster'] != $model->poster){
			$model->poster = $data['poster'];
		}
		//dts
		if($data['updated_by'] != $model->updated_by){
			$model->updated_by = $data['updated_by'];
		}
		//联合发起人
		if($data['co_founder1'] != $model->co_founder1){
			$model->co_founder1 = $data['co_founder1'];
		}
		//嘉宾
		if($data['field7'] != $model->field7){
			$model->field7 = $data['field7'];
		}
		//type_id
		if($data['type_id'] != $model->type_id){
			$model->type_id = $data['type_id'];
		}
		//二级分类
		if($data['tag_id'] != $model->tag_id){
			$model->tag_id = $data['tag_id'];
		}
		//活动系列
		if($data['sequence_id'] != $model->sequence_id){
			$model->sequence_id = $data['sequence_id'];
		}
		//peoples
		if($data['peoples'] != $model->peoples){
			$model->peoples = $data['peoples'];
		}
		//理想人数
		if($data['ideal_number'] != $model->ideal_number){
			$model->ideal_number = $data['ideal_number'];
		}
		//人数上限
		if($data['ideal_number_limit'] != $model->ideal_number_limit){
			$model->ideal_number_limit = $data['ideal_number_limit'];
		}
		//开始时间
		if($data['start_time'] != $model->start_time){
			$model->start_time = $data['start_time'];
		}
		//结束时间
		if($data['end_time'] != $model->end_time){
			$model->end_time = $data['end_time'];
		}
		//活动场地
		if($data['space_spot_id'] != $model->space_spot_id){
			$model->space_spot_id = $data['space_spot_id'];
		}
		//cost
		if($data['cost'] != $model->cost){
			$model->cost = $data['cost'];
		}
		//费用详情cost_list
		if($data['cost_list'] != $model->cost_list){
			$model->cost_list = $data['cost_list'];
		}
		//活动详情描述
		if($data['detail_header'] != $model->detail_header){
			$model->detail_header = $data['detail_header'];
		}
		//活动详情
		if($data['details'] != $model->details){
			$model->details = $data['details'];
		}
		//活动问题
		QuestionService::editQuestion($model->id,$data['question']);

		//活动流程
		if($data['review'] != $model->review){
			$model->review = $data['review'];
		}

		//注意事项
		if($data['field2'] != $model->field2){
			$model->field2 = $data['field2'];
		}
		// Tips
		if($data['field6'] != $model->field6){
			$model->field6 = $data['field6'];
		}
		if(!$model->save()){
			return $model->getErrors();
		}
		return true;
	}
	/**
	 * 获取活动详情
	 */
	public static function getView($id){
		$model = Activity::find()->where(['id'=>$id])->asArray()->one();
		//获取该活动的类型详情
		$type = ActivityType::find()->select(['id','icon_img','name'])->where(['id'=>$model['type_id']])->asArray()->one();
		$model['type'] = $type;
		//判断是否被收藏
		$is_collect  = CollectAct::find()->where(['user_id'=>$user_id,'activity_id'=>$id])->exists();
		$model['is_collect'] = $is_collect?1:0;
		//判断是否拉黑此活动
		$is_black = ActivityBlack::find()->where(['sequence_id'=>$model['sequence_id']])->orWhere(['id'=>$id])->exists();
		$model['is_black'] = $is_balck;
		//获取该活动发起人的详细信息,标签,头像,昵称,简介
		$profile = Profile::find()->select(['headimgurl'])->where(['user_id'=>$model['created_by']])->asArray()->one();
		$user = User::find()->select(['username','founder_desc'])->where(['id'=>$model['created_by']])->asArray()->one();
		$tags = CommonFunction::getUserTags(['user_id'=>$model['created_by']],[],10);
		$model['profile'] = $profile;
		$model['user'] = $user;
		$model['tags'] = $tags;
		//获取哪些用户也参加了这场活动
		$answers = Answer::find()->select(['answer.id','answer.activity_id','answer.user_id'])->joinWith(['profile','user'])->where(['activity_id'=>$model['id']])->asArray()->all();
		$model['answers'] = $answers;
		return $model;
	}

	/**
	 * 更改活动状态
	 */
	public static function updateStatus(){
		$request = Yii::$app->request;
		$data = $request->post();
		if($request->isPut){
			//检查该活动的所有者
			$own = Activity::find()->where(['created_by'=>$data['user_id'],'id'=>$data['id']])->exists();
			if(!$own){
				return ['status'=>0,'data'=>'活动拥有者错误'];
			}
			$status = 10;
			switch ($data['status']) {
				case 'check':
					$status = Activity::STATUS_CHECK;
					break;
				case 'pass':
					$status = Activity::STATUS_PASS;
					break;
				case 'reject':
					$status = Activity::STATUS_REFUSE;
					break;
				case 'release':
					$status = Activity::STATUS_RELEASE;
					break;
				
				default:
					# code...
					break;
			}
			if(!isset($data['reject_resason'])) $data['reject_resason'] = '';
			if(Activity::updateAll(['status'=>$status,'reject_resason'=>$data['reject_resason']],['id'=>$data['id']])){
				return ['status'=>1,'data'=>'操作成功'];
			}
		}
		return ['status'=>0,'data'=>'error'];
	}

	/**
	 * 获取活动的详情
	 */
	public static function getDetail($id){
		if(!$id) return false;
		//基本信息
		$info = Activity::find()->asArray()->where(['id'=>$id])->one();
		//查询活动发起人姓名
		$user = User::find()->select(['username'])->where(['id'=>$info['created_by']])->asArray()->one();
		$info['username'] = $user['username'];
		//联合发起人
		$info['co_username'] = '';
		if($info['co_founder1']){
			$co_user = User::find()->select(['username'])->where(['id'=>$info['co_founder1']])->asArray()->one();
			$info['co_username'] = $co_user['username'];
		}
		//获取图片列表
		$actImg = ActivityAlbum::find()->select(['img','id'])->where(['activity_id'=>$info['id']])->orderBy("id desc")->asArray()->all();
		$info['actImg'] = json_encode($actImg);
		//获取活动问题
		$question = [];
		$qid = Question::find()->select(['id'])->where(['activity_id'=>$info['id']])->one();
		$qitem = [];
		if($qid){
			$qitem = QuestionItem::find()->select(['label','id'])->where(['question_id'=>$qid->id])->asArray()->all();
		}
		$info['question'] = $qitem;
		$header = unserialize($info['detail_header']);
		$info['header_title'] = $header[0];
		$info['header_people'] = $header[1];
		$field7 = !empty($info['field7'])?unserialize($info['field7']):[];
		$info['field7'] = $field7;
		//获取场地名称
		$space = FounderSpaceSpot::find()->select(['name','id'])->where(['id'=>$info['space_spot_id']])->asArray()->one();
		$info['spacename'] = $space['name'];
		//反序列化活动流程
		$info['review'] = is_serialized($info['review'])?unserialize($info['review']):[];
		$info['field2'] = is_serialized($info['field2'])?unserialize($info['field2']):[];
		$info['field6'] = is_serialized($info['field6'])?unserialize($info['field6']):[];
		return $info;
	}





}