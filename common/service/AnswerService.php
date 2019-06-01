<?php
namespace app\common\service;
use app\common\service\BaseService;
use app\common\service\QuestionService;
use app\models\Activity;
use app\models\ActivityType;
use app\models\Question;
use app\models\User;
use app\models\Profile;
use app\models\ActivityBlack;
use app\models\CollectAct;
use app\models\Answer;
use app\models\FounderSpaceSpot;
use app\models\SpaceSpot;
use app\models\QuestionItem;
use app\models\ActivityAlbum;
use yii\web\Response;
use Yii;
use yii\db\ActiveQuery;
use app\component\CommonFunction;
use yii\data\Pagination;
class AnswerService extends BaseService{
	//报名前检查活动能否报名
	public static function checkAnswer($id){
		if(!$id) return false;
		$model = Activity::find()->select(['id','status','is_full'])->where(['id'=>$id])->one();
		if(!$model) return false;
        $is_apply =
                    self::Isfull($id) == Activity::IS_FULL_YES
                    || self::applyConflict($id)['has_conflict'] == 2 // 活动冲突
                    || $model->status != Activity::STATUS_RELEASE //只要活动不是发布状态都不可以报名
                    ;
        return $is_apply ? Answer::APPLY_NO : Answer::APPLY_YES;
	}

    /**
     * 更新活动是否已满
     * @param  init $activity_id 活动id
     * @return bool 返回布尔值
     */
    public static function updateIsfull($activity_id)
    {
        if (self::Isfull($activity_id) == Activity::IS_FULL_YES) {
            $isfull = Activity::updateAll(['is_full' => Activity::IS_FULL_YES], ['id' => $activity_id]);
        } elseif (self::Isfull($activity_id) == Activity::IS_FULL_NO) {
            $isfull = Activity::updateAll(['is_full' => Activity::IS_FULL_NO], ['id' => $activity_id]);
        }
        return true;
    }

    /**
     * 判断活动是否已满
     * 已通过人数 - 已经请假人数 = 理想报名人数上限 不能再报名
     * （通过人数为零）待筛选人数 = 报名名额 不能再报名
     * （通过人数 - 请假人数 = N，N小于理想人数上限 即未达到2的标准）
     * 	待筛选人数不超过 min （（理想人数上限-N）*2，报名名额 - 理想人数上限）
     * @param  init $id 活动id
     * @return 返回 1不可以报名 或 0可以报名
     */
    public static function Isfull($activity_id)
    {
        $activity = Activity::find()->select(['ideal_number_limit','peoples','id','ideal_number'])->where(['id'=>$activity_id])->one();;

        // 已通过人数
        $passCount = Answer::find()
                ->where([
                    'activity_id' => $activity_id,
                    'status' => Answer::STATUS_REVIEW_PASS,
                    ])
                ->count();

        //通过后请假人数
        $leaveCount = Answer::find()
                ->where([
                    'activity_id' => $activity_id,
                    'status' => Answer::STATUS_REVIEW_PASS,
                    'leave_status' => Answer::STATUS_LEAVE_YES
                    ])
                ->orWhere([
                    'activity_id' => $activity_id,
                    'status' => Answer::STATUS_REVIEW_PASS,
                    'pay_status' => Answer::PAY_TIMEOUT])
                ->count();

        // 待筛选人数
        $answer_filter = Answer::find()->where([
                    'activity_id' => $activity_id,
                    'status' => Answer::STATUS_REVIEW_YET,
                    'apply_status' => Answer::APPLY_STATUS_YES,
                    ])
                    ->count();

        // 通过人数为零的情况下待筛选人数
        if ($passCount == 0) {
            $answer_filter = Answer::find()->where([
                        'activity_id' => $activity_id,
                        'status' => Answer::STATUS_REVIEW_YET,
                        'apply_status' => Answer::APPLY_STATUS_YES,
                        ])
                        ->count();
            // （通过人数为零）待筛选人数 >= 报名名额 不能再报名
            if ($answer_filter >= $activity->peoples) {
                return Activity::IS_FULL_YES;
            }
        }

        // 真实报名的人数 N
        $actualPass = $passCount - $leaveCount;

        // 已通过人数 - 已经请假人数 >= 理想报名人数上限 不能再报名
        if ($actualPass >= $activity->ideal_number_limit) {
            return Activity::IS_FULL_YES;
        };

        // （通过人数 - 请假人数 = N，N小于理想人数上限 即未达到2的标准）待筛选人数不超过 min （（理想人数上限-N）*2，报名名额 - 理想人数上限）
        $is_full =  $answer_filter < min(
                        (($activity->ideal_number_limit - $actualPass) * 2),
                        ($activity->peoples - $actualPass)
                    )
                    ? Activity::IS_FULL_NO
                    : Activity::IS_FULL_YES;
        return $is_full;
    }
    /**
     * 活动报名的冲突检测 检测与自己已经报名的活动是否冲突
     * @param  integer $id 活动id
     * @return json  返回与报名冲突的活动
     */
    public static function applyConflict($id)
    {
        $user_id = Yii::$app->user->id;
        //检查参数
        if (!is_numeric($id)) {
            throw new DataValidationFailedException('参数错误');
        }

        $timeDistinct = 1790; //1个小时

        //查询前活动的开始时间和结束时间分别是多少
        $currentActivity = Activity::findOne($id);
        if (empty($currentActivity)) {
            throw new ObjectNotExistsException('当前活动不存在');
        }

        //将开始时间-1小时，将结束时间添加1小时
        $startTime = $currentActivity->start_time - $timeDistinct;
        $endTime = $currentActivity->end_time + $timeDistinct;

        //获取隐藏的活动分类编号
        $activity_test_type_ids = ActivityType::find()->select('id')->where(['status' => ActivityType::STATUS_HIDDEN])->all();
        $activity_test_type_ids = is_array($activity_test_type_ids) ? array_column($activity_test_type_ids, 'id') : [];

        $activity = Activity::findOne($id);
        if (in_array($activity->type_id, $activity_test_type_ids)) {
            return ['has_conflict' => 0, 'activities' => null];
        }
        //查询活动开始时间-1小时大于最小时间，或者结束时间加1小时小于最大时间, 并且id不是当前活动id

        $conflictActivities = Activity::find()
            ->joinWith('type')
            ->where(['activity_type.status' => ActivityType::STATUS_NORMAL])
            ->andwhere(['between', 'start_time', $startTime, $endTime])
            ->orWhere(['between', 'end_time', $startTime, $endTime])
            ->andWhere('activity.id != ' . $id)
            ->andWhere(['activity.status'=>Activity::STATUS_RELEASE])
            ->asArray()
            ->exists();

        //如果存在冲突的活动
        if ($conflictActivities) {
            return ['has_conflict' => 1, 'activities' => null];
        } else {
            //不存在冲突的活动，可以正常进行报名
            return ['has_conflict' => 0, 'activities' => null];
        }
    }
}