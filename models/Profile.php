<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $user_id
 * @property string $name
 * @property string $public_email
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $bio 自我介绍
 * @property string $country 国家
 * @property string $province 省份
 * @property string $city 城市
 * @property string $headimgurl 头像地址
 * @property int $sex 性别
 * @property int $birth_year
 * @property int $birth_month
 * @property int $birth_day
 * @property string $constellation 星座, 根据生日自动生成
 * @property string $zodiac
 * @property string $company 公司
 * @property string $education 学历
 * @property string $occupation 职业
 * @property string $position 职位
 * @property string $affective_status 情感状态
 * @property string $lookingfor 交友目的
 * @property string $blood_type 血型
 * @property string $height 身高
 * @property string $weight 体重
 * @property string $interest 兴趣爱好
 * @property string $from 1 朋友圈 2 朋友推荐 3 耳闻, 自己找到的
 * @property string $want 1 独特体验拉轰活动 2 志同道合 3 生活技能和硬知识 4 聊天谈理想 5 融入兴趣圈子
 * @property string $recommand 推荐一个身边有趣的人
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'sex', 'birth_year', 'birth_month', 'birth_day'], 'integer'],
            [['bio', 'recommand'], 'string'],
            [['name', 'public_email', 'gravatar_email', 'location', 'website', 'country', 'province', 'city', 'headimgurl', 'constellation', 'zodiac', 'company', 'education', 'occupation', 'position', 'affective_status', 'lookingfor', 'blood_type', 'height', 'weight', 'interest', 'from', 'want'], 'string', 'max' => 255],
            [['gravatar_id'], 'string', 'max' => 32],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'name' => 'Name',
            'public_email' => 'Public Email',
            'gravatar_email' => 'Gravatar Email',
            'gravatar_id' => 'Gravatar ID',
            'location' => 'Location',
            'website' => 'Website',
            'bio' => 'Bio',
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'headimgurl' => 'Headimgurl',
            'sex' => 'Sex',
            'birth_year' => 'Birth Year',
            'birth_month' => 'Birth Month',
            'birth_day' => 'Birth Day',
            'constellation' => 'Constellation',
            'zodiac' => 'Zodiac',
            'company' => 'Company',
            'education' => 'Education',
            'occupation' => 'Occupation',
            'position' => 'Position',
            'affective_status' => 'Affective Status',
            'lookingfor' => 'Lookingfor',
            'blood_type' => 'Blood Type',
            'height' => 'Height',
            'weight' => 'Weight',
            'interest' => 'Interest',
            'from' => 'From',
            'want' => 'Want',
            'recommand' => 'Recommand',
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
