<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "r_tag_activity".
 *
 * @property integer $id
 * @property integer $activity_id
 * @property integer $tag_id
 */
class RTagActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_tag_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'tag_id'], 'required'],
            [['activity_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => '活动ID',
            'tag_id' => '标签ID',
        ];
    }
    // 活动
    public function getActivity()
    {
        return $this->hasMany(Activity::className(), ['id' => 'activity_id']);
    }

    // 标签对应活动数据
    public function getManyActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }

    /**
     * 统计本周的标签数量
     * @return [type] [description]
     */
    public function getWeekActivity()
    {
        return $this->hasMany(Activity::className(), ['id' => 'activity_id']);
    }

}
