<?php

namespace app\models;
use app\models\BaseUser;
use Yii;
class User extends BaseUser
{
    public $sex;
    /** * 用户状态是删除 */
    const STATUS_DELETED = 0;
    /** * 用户状态是正常 */
    const STATUS_ACTIVE = 10;
    /** * 用户状态是封禁 */
    const STATUS_LOCK = -10;
    /** * 用户在白名单 */
    const WHITE_LIST_YES = 1;
    /** * 用户不在白名单 */
    const WHITE_LIST_NO = 0;

    /** * 用户在黑名单 */
    const BLACK_LIST_YES = 1;
    /** * 用户不在黑名单 */
    const BLACK_LIST_NO = 0;
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
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        if (!empty($password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
    }

    /**
     * @return string|null the current password value, if set from form. Null otherwise.
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new email confirmation token
     * @param bool $save whether to save the record. Default is `false`.
     * @return bool|null whether the save was successful or null if $save was false.
     */
    public function generateEmailConfirmationToken($save = false)
    {
        $this->email_confirmation_token = Yii::$app->security->generateRandomString() . '_' . time();
        if ($save) {
            return $this->save();
        }
    }

    /**
     * Generates new password reset token
     * @param bool $save whether to save the record. Default is `false`.
     * @return bool|null whether the save was successful or null if $save was false.
     */
    public function generatePasswordResetToken($save = false)
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
        if ($save) {
            return $this->save();
        }
    }

    /**
     * Resets to a new password and deletes the password reset token.
     * @param string $password the new password for this user.
     * @return bool whether the record was updated successfully
     */
    public function resetPassword($password)
    {
        $this->setPassword($password);
        $this->password_reset_token = null;
        return $this->save();
    }

    /**
     * Confirms an email an deletes the email confirmation token.
     * @return bool whether the record was updated successfully
     */
    public function confirmEmail()
    {
        $this->email_confirmation_token = null;
        $this->is_email_verified = 1;
        return $this->save();
    }
    /**
     * Profile
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * 活动列表
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasMany(Activity::className(), ['created_by' => 'id']);
    }

    // 获得角色对象
    public function getAssignment()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }
	
}
