<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_idcard_check".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $realname
 * @property string $idcard
 * @property integer $created_at
 * @property integer $status
 * @property string $reject_reason
 * @property string $idcards_A
 * @property string $idcards_B
 */
class UserIdcardCheck extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_idcard_check';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'realname', 'idcard', 'idcards_A', 'idcards_B'], 'required'],
            [['user_id', 'created_at', 'status'], 'integer'],
            [['realname', 'reject_reason', 'idcards_A', 'idcards_B'], 'string', 'max' => 255],
            [['idcard'], 'string', 'max' => 20],
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
            'realname' => 'Realname',
            'idcard' => 'Idcard',
            'created_at' => 'Created At',
            'status' => 'Status',
            'reject_reason' => 'Reject Reason',
            'idcards_A' => 'Idcards  A',
            'idcards_B' => 'Idcards  B',
        ];
    }
}
