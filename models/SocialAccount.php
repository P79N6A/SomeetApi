<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "social_account".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $provider
 * @property string $client_id
 * @property string $data
 * @property string $code
 * @property integer $created_at
 * @property string $email
 * @property string $username
 * @property string $unionid
 *
 * @property User $user
 */
class SocialAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'social_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'integer'],
            [['provider'], 'required'],
            [['data'], 'string'],
            [['provider', 'client_id'], 'string', 'max' => 190],
            [['code'], 'string', 'max' => 32],
            [['email', 'username'], 'string', 'max' => 255],
            [['unionid'], 'string', 'max' => 60],
            [['provider', 'client_id'], 'unique', 'targetAttribute' => ['provider', 'client_id'], 'message' => 'The combination of Provider and Client ID has already been taken.'],
            [['code'], 'unique'],
            [['unionid', 'client_id'], 'unique', 'targetAttribute' => ['unionid', 'client_id'], 'message' => 'The combination of Client ID and Unionid has already been taken.'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'provider' => 'Provider',
            'client_id' => 'Client ID',
            'data' => 'Data',
            'code' => 'Code',
            'created_at' => 'Created At',
            'email' => 'Email',
            'username' => 'Username',
            'unionid' => 'Unionid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
