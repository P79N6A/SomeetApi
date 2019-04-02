<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_push".
 *
 * @property int $id
 * @property int $user_id 用户编号
 * @property string $jiguang_id 极光编号
 * @property string $content 推送内容
 * @property string $from_type 内容来源类型，例如活动，用户等
 * @property int $from_id 来源编号，如果是活动的话，则是活动编号
 * @property int $from_status 来源的状态 例如活动的通过，不通过状态
 * @property int $is_join_queue 是否加入队列 0 未加入 1加入
 * @property int $join_at 加入队列时间
 * @property int $is_push 是否推送 0未推送 1推送
 * @property int $is_read 是否已读 0 未读 1 已读
 * @property int $push_at 推送时间
 * @property int $created_at 创建时间
 * @property int $status 状态 
 */
class AppPush extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_push';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'from_id', 'from_status', 'is_join_queue', 'join_at', 'is_push', 'is_read', 'push_at', 'created_at', 'status'], 'integer'],
            [['content', 'from_type'], 'required'],
            [['jiguang_id'], 'string', 'max' => 64],
            [['content', 'from_type'], 'string', 'max' => 255],
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
            'jiguang_id' => 'Jiguang ID',
            'content' => 'Content',
            'from_type' => 'From Type',
            'from_id' => 'From ID',
            'from_status' => 'From Status',
            'is_join_queue' => 'Is Join Queue',
            'join_at' => 'Join At',
            'is_push' => 'Is Push',
            'is_read' => 'Is Read',
            'push_at' => 'Push At',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
