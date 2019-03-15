<?php

namespace app\models;
use app\models\BaseUser;
use Yii;
class User extends BaseUser
{
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            // password rules
            'passwordRequired' => ['password', 'required', 'on' => ['register']],
            'passwordLength'   => ['password', 'string', 'min' => 6, 'on' => ['register', 'create']],

            // [['email','password'], 'required', 'on'=>'signup'],

            ['black_label', 'default', 'value' => self::BLACK_LIST_NO],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['mobile', 'unique'],
            [['wechat_id'], 'unique'],
            [['last_login_at','black_time', 'black_label'], 'integer'],
            ['password_reset_token', 'string', 'max' => 60],
            ['email_confirmation_token', 'string', 'max' => 60],

            ['access_token', 'default', 'value' => Yii::$app->security->generateRandomString(), 'on' => ['register', 'create']],
            [['last_login_at', 'password_reset_token', 'email_confirmation_token'], 'safe'],
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        unset(
            $fields['password_hash'],
            $fields['auth_key'],
            $fields['email_confirmation_token'],
            $fields['password_reset_token'],
            $fields['email'],
            $fields['confirmed_at'],
            $fields['blocked_at'],
            $fields['registration_ip'],
            $fields['in_white_list'],
            $fields['is_email_verified'],
            $fields['unconfirmed_email'],
            $fields['access_token'],
            $fields['unionid']
        );

        return $fields;
    }
    public static function checkUser($data){
       $user = User::find()->select(['username','password_hash'])->where(['username'=>trim($data['username'])])->one();
       return $user?$user->password_hash== self::validatePassword($data['password'],$user->password_hash):false;
    }
    //验证密码
    public function validatePassword($password,$password_hash)
    {
        return Yii::$app->security->validatePassword($password, $password_hash);
    }
	
	/**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
	
    /**
     * 可以通过 expand 获取的数据
     * @return array
     */
    public function extraFields()
    {
        return ['profile', 'checkInList','ugaPraiseList', 'ugaAnswerList', 'ugaQuestionList', 'answerList', 'assignment', 'activity'];
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
	
	/** @inheritdoc */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
	
}
