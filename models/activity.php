<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property int $id
 * @property int $city_id
 * @property string $city
 * @property int $type_id 分类ID
 * @property string $title 标题
 * @property string $desc 描述
 * @property string $poster 海报
 * @property int $week 星期 按照活动时间自动计算
 * @property int $start_time 活动开始时间
 * @property int $end_time 活动结束时间
 * @property string $area 范围, 比如雍和宫
 * @property string $address 活动详细地址
 * @property string $address_assign 场地是否分配
 * @property string $details 活动详情
 * @property string $group_code 群二维码
 * @property double $longitude 经度
 * @property double $latitude 纬度
 * @property int $cost 0 免费 大于0 则收费
 * @property string $cost_list 收费明细 当收费模式有值
 * @property int $peoples 0 不限制 >1 则为限制人数
 * @property int $ideal_number 理想人数
 * @property int $ideal_number_limit 理想人数限制
 * @property int $is_volume 0 非系列 1 系列活动
 * @property int $is_digest 0 非精华 1 精华
 * @property int $is_top 0 正常 1 置顶
 * @property int $principal 负责人 0为未设置
 * @property int $pma_type 是否是线上pma 或线下pma 0 线上 1 线下
 * @property string $review 活动回顾
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $status 0 删除 10 草稿 20 发布
 * @property int $edit_status 扩展字段, 前端自定义状态
 * @property int $display_order 排序，从小到大排序，1在前，99在后
 * @property string $content 文案
 * @property int $apply_rate 报名率
 * @property string $field1 自定义字段1
 * @property string $field2 自定义字段2
 * @property string $field3 自定义字段3
 * @property string $field4 自定义字段4
 * @property string $field5 自定义字段5
 * @property string $field6 自定义字段6
 * @property string $field7 自定义字段7
 * @property string $field8 自定义字段8
 * @property int $co_founder1 联合发起人1
 * @property int $co_founder2 联合发起人2
 * @property int $co_founder3 联合发起人3
 * @property int $co_founder4 联合发起人4
 * @property int $is_full 是否已报满 0 未报满 1 已报满
 * @property int $join_people_count 已报名人数
 * @property int $space_spot_id 场地id
 * @property int $sequence_id 活动系列ID
 * @property int $version_number 活动版本号
 * @property int $group_id 活动所属组
 * @property int $is_display 0 不显示 1 显示
 * @property int $allow_vip 0 不允许非vip报名 1 允许非vip报名
 * @property int $want_allow_vip 0 不希望全平台开放 1 希望对全平台开放
 * @property int $is_rfounder 0 没有嘉宾或联合发起人 1 有嘉宾或联合发起人
 * @property string $reject_reason 审核不通过理由  用于审核发起人提交的活动
 * @property int $tag_id 二级分类id
 * @property string $act_tag_id 活动标签id
 * @property string $district 所属城区
 * @property string $detail_header 活动详情默认开头部分内容
 * @property int $first_publish_date 第一次发布活动的时间
 * @property string $cancel_reason 对接的dts
 * @property int $push_check_time 提交审核时间
 * @property int $update_groupCode_time 上传二维码的时间
 * @property int $collect_num 收藏人数
 * @property int $is_recommend 是否是特别推荐
 * @property int $is_set_question 是否设置筛选问题
 * @property int $is_prevent_push 是否预发布push
 * @property int $is_push_on 是否开启push
 * @property int $is_new 是否是app活动
 */
class Activity extends \yii\db\ActiveRecord
{
	public $answer_list;
	public $type;
	public $is_collect;
	public $is_black;
    public $username;
    /* 删除 */
    const STATUS_DELETE   = 0;
    /* 不通过的发起人创建的活动 */
    const STATUS_REFUSE = 3;
    /* 通过的发起人创建的活动 */
    const STATUS_PASS = 12;
    /* 发起人创建的活动的草稿 */
    const STATUS_FOUNDER_DRAFT = 5;
    /* 草稿 */
    const STATUS_DRAFT    = 10;
    /* 预发布 */
    const STATUS_PREVENT  = 15;
    /* 发布 */
    const STATUS_RELEASE  = 20;
    /* 关闭 */
    const STATUS_SHUT  = 30;
    /* 取消 */
    const STATUS_CANCEL = 40;
    /* 待审核 */
    const STATUS_CHECK = 8;
    /* 好评 */
    const GOOD_SCORE = 1;
    /* 中评 */
    const MIDDLE_SCORE = 2;
    /* 差评 */
    const BAD_SCORE = 3;

    /* 报名已满 */
    const IS_FULL_YES = 1;
    /* 报名未满 */
    const IS_FULL_NO = 0;

    /* 显示 */
    const DISPLAY_YES =  1;
    /* 不显示 */
    const DISPLAY_NO =  0;
    //收藏数
    public $collect;
    public $new_collect;
    // 标签名, 用于标签行为使用此属性
    public $tagNames;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'type_id', 'week', 'start_time', 'end_time', 'cost', 'peoples', 'ideal_number', 'ideal_number_limit', 'is_volume', 'is_digest', 'is_top', 'principal', 'pma_type', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'edit_status', 'display_order', 'apply_rate', 'co_founder1', 'co_founder2', 'co_founder3', 'co_founder4', 'is_full', 'join_people_count', 'space_spot_id', 'sequence_id', 'version_number', 'group_id', 'is_display', 'allow_vip', 'want_allow_vip', 'is_rfounder', 'tag_id', 'first_publish_date', 'push_check_time', 'update_groupCode_time', 'collect_num', 'is_recommend', 'is_set_question', 'is_prevent_push', 'is_push_on', 'is_new'], 'integer'],
            [['title', 'desc', 'poster', 'area', 'address', 'details', 'group_code', 'longitude', 'latitude'], 'required'],
            [['details', 'review', 'content', 'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8', 'cancel_reason'], 'string'],
            [['longitude', 'latitude'], 'number'],
            [['city'], 'string', 'max' => 60],
            [['title'], 'string', 'max' => 80],
            [['desc', 'poster', 'address', 'address_assign', 'group_code', 'reject_reason', 'detail_header'], 'string', 'max' => 255],
            [['area'], 'string', 'max' => 10],
            [['cost_list'], 'string', 'max' => 190],
            [['act_tag_id', 'district'], 'string', 'max' => 100],
        ];
    }
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($insert){
                $this->created_at  = time();
                $this->push_check_time  = time();
            }
        }
         return true;
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        $fields = parent::fields();

        unset(
            $fields['allow_vip'],
            $fields['apply_rate'],
            $fields['cancel_reason'],
            $fields['edit_status'],
            $fields['first_publish_date'],
            $fields['is_digest'],
            $fields['is_display'],
            $fields['is_prevent_push'],
            $fields['is_push_on'],
            $fields['is_top'],
            $fields['is_volume'],
            $fields['pma_type'],
            $fields['push_check_time'],
			$fields['update_groupCode_time'],
			$fields['updated_at'],
			$fields['updated_by'],
			$fields['version_number'],
			$fields['want_allow_vip'],
			$fields['reject_reason']
        );

        return $fields;
    }
	// 活动标签
    public function getTags()
    {
        return $this->hasMany(ActivityTag::className(), ['id' => 'tag_id'])->viaTable('r_tag_activity', ['activity_id' => 'id']);
    }

    // PMA
    public function getPma()
    {
        return $this->hasOne(User::className(), ['id' => 'principal']);
    }

    // DTS
    public function getDts()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    // 发起人
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }


    // 联合发起人1
    public function getCofounder1()
    {
        return $this->hasOne(User::className(), ['id' => 'co_founder1']);
    }
    // 发起人选择的标签
    public function getFounderTags()
    {
        return $this->hasMany(UserSelectTags::className(), ['user_id' => 'created_by']);
    }
    // 联合发起人2
    public function getCofounder2()
    {
        return $this->hasOne(User::className(), ['id' => 'co_founder2']);
    }
    // 联合发起人3
    public function getCofounder3()
    {
        return $this->hasOne(User::className(), ['id' => 'co_founder3']);
    }
    // 联合发起人4
    public function getCofounder4()
    {
        return $this->hasOne(User::className(), ['id' => 'co_founder4']);
    }

    /**
     * 类型
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ActivityType::className(), ['id' => 'type_id'])->select(['id','status','name','img']);
    }

    // 活动的场地
    public function getSpace()
    {
        return $this->hasOne(SpaceSpot::className(), ['id' => 'space_spot_id']);
    }

    /**
     * 活动问题
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['activity_id' => 'id']);
    }

    /**
     * 报名列表
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerList()
    {
        return $this->hasMany(Answer::className(), ['activity_id' => 'id']);
    }

    /**
     * 反馈列表
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbackList()
    {
        return $this->hasMany(ActivityFeedback::className(), ['activity_id' => 'id']);
    }

    /**
     * 黄牌列表
     * @return \yii\db\ActiveQuery
     */
    public function getYellowCardList()
    {
        return $this->hasMany(YellowCard::className(), ['activity_id' => 'id']);
    }

    /**
     * 签到列表
     * @return \yii\db\ActiveQuery
     */
    public function getCheckInList()
    {
        return $this->hasMany(ActivityCheckIn::className(), ['activity_id' => 'id']);
    }

    /**
     * 联合发起人列表
     * @return \yii\db\ActiveQuery
     */
    public function getRActivityFounder()
    {
        return $this->hasMany(RActivityFounder::className(), ['activity_id' => 'id']);
    }

    /**
     * 场地
     * @return \yii\db\ActiveQuery
     */
    public function getSpot()
    {
        return $this->hasOne(SpaceSpot::className(), ['id' => 'space_spot_id']);
    }

    public function getFounders()
    {
        return $this->hasMany(User::className(), ['id' => 'founder_id'])->viaTable('r_activity_founder', ['activity_id' => 'id']);
    }

    /**
     * 活动对应的日志列表
     * @return $this
     */
    public function getLogs()
    {
        return $this->hasMany(AdminLog::className(), ['handle_id' => 'id'])->where(['controller' => 'activity'])->orderBy(['id' => SORT_DESC]);
    }

    /**
     * 标签和活动对应列表
     * @return \yii\db\ActiveQuery
     */
    public function getRTagActivity()
    {
        return $this->hasOne(RTagActivity::className(), ['activity_id' => 'id']);
    }
}
