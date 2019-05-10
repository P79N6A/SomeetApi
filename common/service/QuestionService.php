<?php
namespace app\common\service;
use app\common\service\BaseService;
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
class QuestionService extends BaseService{
	/**
	 * 添加活动问题
	 */
	public static function addQuestion($id,$question){
		if($id>0){
			$q = new Question();
			$q->activity_id = $id;
			$q->created_at = time();
			$q->status = 10;
			if($q->save()){
				//添加item
				return self::addItem($question,$q->id);
			}else{
				return $q->getErrors();
			}
		}
		return false;
	}


	/**
	 * 修改活动问题
	 */
	public static function editQuestion($id,$question){
		//查询该活动的问题id
		$qid = Question::find()->select(['id'])->where(['activity_id'=>$id])->asArray()->one();
		if($qid){
			return self::editItem($question,$qid['id']);
		}else{
			return self::addQuestion($id,$question);
		}
		return false;
	}

	/**
	 * 添加问题
	 */
	public static function addItem($question,$qid){
		foreach ($question as $row) {
			//创建活动问题
			$qitem = new QuestionItem();
			$qitem->question_id = $qid;
			$qitem->label = $row;
			if(!$qitem->save()){
				return $qitem->getErrors();
			}
		}
		return true;
	}

	/**
	 * 修改问题
	 */
	public static function editItem($question,$qid){
		foreach ($question as $key=>$row) {
			//查询是否存在item
			$qitem = QuestionItem::find()->where(['question_id'=>$qid,'id'=>$key])->one();
			if(!$qitem){
				$qitem = new QuestionItem();
			}
			//创建活动问题
			$qitem->question_id = $qid;
			$qitem->label = $row;
			if(!$qitem->save()){
				return $qitem->getErrors();
			}
		}
		return true;
	}
}