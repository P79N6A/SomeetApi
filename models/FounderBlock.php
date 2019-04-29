<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "founder_block".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $username
 * @property string $openid
 * @property integer $is_block_send
 * @property integer $is_free_send
 * @property integer $created_at
 * @property integer $due_date
 * @property integer $pass_date
 * @property string $block_reason
 * @property integer $status
 * @property integer $admin_id
 */
class FounderBlock extends \yii\db\ActiveRecord
{   
    const STATUS_BLOCK  = 1;

    const STATUS_NORMAL = 0;

    public static $arrStatus = array(
        self::STATUS_BLOCK => '屏蔽中',
        self::STATUS_NORMAL => '已失效',
    );
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'founder_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'is_block_send', 'is_free_send', 'created_at', 'due_date', 'pass_date', 'status', 'admin_id'], 'integer'],
            [['username', 'openid', 'block_reason'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'username' => 'Username',
            'openid' => 'Openid',
            'is_block_send' => 'Is Block Send',
            'is_free_send' => 'Is Free Send',
            'created_at' => 'Created At',
            'due_date' => 'Due Date',
            'pass_date' => 'Pass Date',
            'block_reason' => 'Block Reason',
            'status' => 'Status',
            'admin_id' => 'Admin ID',
        ];
    }
}
