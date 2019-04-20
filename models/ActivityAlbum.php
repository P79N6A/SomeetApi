<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_album".
 *
 * @property integer $id
 * @property integer $activity_id
 * @property string $img
 * @property integer $type
 */
class ActivityAlbum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'type'], 'integer'],
            [['img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => 'Activity ID',
            'img' => 'Img',
            'type' => 'Type',
        ];
    }
}
