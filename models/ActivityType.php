<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_type".
 *
 * @property int $id
 * @property int $city_id
 * @property string $city
 * @property string $name 分类名称
 * @property int $display_order 显示顺序
 * @property int $status 0 删除 10 正常 20 隐藏
 * @property string $img
 * @property string $share_title 分享标题
 * @property string $share_desc 分享描述
 * @property string $share_link 分享链接
 * @property string $share_img 分享图片
 * @property string $type_img 分类图片
 * @property string $icon_img icon图片
 * @property string $app_img 职业
 * @property string $app_select_img 职业
 * @property string $app_icon_img 职业
 * @property string $app_icon_select_img 职业
 * @property int $is_app
 */
class ActivityType extends \yii\db\ActiveRecord
{
	/* 删除 */
    const STATUS_DELETE     = 0;
    /* 正常 */
    const STATUS_NORMAL    = 10;
    /* 隐藏 */
    const STATUS_HIDDEN  = 20;
    public $class_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'display_order', 'status', 'is_app'], 'integer'],
            [['name'], 'required'],
            [['city'], 'string', 'max' => 60],
            [['name', 'img', 'share_title', 'share_desc', 'share_link', 'share_img', 'type_img', 'icon_img', 'app_img', 'app_select_img', 'app_icon_img', 'app_icon_select_img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => '城市编号',
            'city' => '城市',
            'name' => '名称',
            'display_order' => '显示顺序',
            'status' => 'Status',
            'img' => '图片',
        ];
    }

    /**
     * 活动列表
     * @return int|string
     */
    public function getActivities()
    {
        return $this->hasOne(Activity::className(), ['type_id' => 'id']);
    }

    /**
     * 二级分类
     * @return int|string
     */
    public function getTagAct()
    {
        return $this->hasMany(TagAct::className(), ['pid' => 'id']);
    }
}
