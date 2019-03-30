<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_black".
 *
 * @property int $id
 * @property int $user_id
 * @property int $status
 * @property int $activity_id
 * @property int $sequence_id
 * @property int $founder_id
 * @property int $created_at
 * @property int $updated_at
 */
class ActivityBlack extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_black';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'activity_id'], 'required'],
            [['user_id', 'status', 'activity_id', 'sequence_id', 'founder_id', 'created_at', 'updated_at'], 'integer'],
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
            'status' => 'Status',
            'activity_id' => 'Activity ID',
            'sequence_id' => 'Sequence ID',
            'founder_id' => 'Founder ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
