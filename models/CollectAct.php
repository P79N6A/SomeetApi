<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collect_act".
 *
 * @property int $id 自增id
 * @property int $user_id 收藏用户
 * @property int $activity_id 活动id
 * @property string $activity_name 活动名称
 * @property int $status 收藏状态 默认0，1为收藏
 * @property string $note 备注
 * @property int $created_at 收藏时间
 * @property int $updated_at 操作时间
 * @property int $data_type
 */
class CollectAct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collect_act';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'activity_id', 'status', 'created_at', 'updated_at', 'data_type'], 'integer'],
            [['activity_name', 'note'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'activity_id' => 'Activity ID',
            'activity_name' => 'Activity Name',
            'status' => 'Status',
            'note' => 'Note',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'data_type' => 'Data Type',
        ];
    }
}
