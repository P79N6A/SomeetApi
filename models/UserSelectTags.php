<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_select_tags".
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property int $tag_id 标签ID
 * @property int $status 状态 1：正常  0:取消
 * @property int $type_id 标签类型ID
 * @property int $created_at 创建时间
 * @property string $tag_title
 * @property int $type_pid
 * @property string $from
 */
class UserSelectTags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_select_tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'tag_id', 'type_id'], 'required'],
            [['user_id', 'tag_id', 'status', 'type_id', 'created_at', 'type_pid'], 'integer'],
            [['tag_title'], 'string', 'max' => 200],
            [['from'], 'string', 'max' => 255],
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
            'tag_id' => 'Tag ID',
            'status' => 'Status',
            'type_id' => 'Type ID',
            'created_at' => 'Created At',
            'tag_title' => 'Tag Title',
            'type_pid' => 'Type Pid',
            'from' => 'From',
        ];
    }
	public function fields(){
		// 'id','tag_id','type_id','tag_title','type_pid','from'
		$fields = parent::fields();
		unset($fields['status'],$fields['created_at']);
	}
}
