<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "founder_space_spot".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $city_id
 * @property string $city
 * @property string $name
 * @property string $area
 * @property string $address
 * @property integer $type_id
 * @property string $image
 * @property string $router
 * @property string $map_pic
 * @property string $detail
 * @property string $contact
 * @property string $base_fee
 * @property integer $principal
 * @property string $logo
 * @property string $owner
 * @property string $open_time
 * @property double $longitude
 * @property double $latitude
 * @property integer $status
 */
class FounderSpaceSpot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'founder_space_spot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'city_id', 'type_id', 'principal', 'status'], 'integer'],
            [['address', 'detail'], 'string'],
            [['longitude', 'latitude'], 'number'],
            [['city'], 'string', 'max' => 60],
            [['name', 'area', 'image', 'router', 'map_pic', 'contact', 'base_fee', 'owner', 'open_time'], 'string', 'max' => 180],
            [['logo'], 'string', 'max' => 45],
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
            'city_id' => 'City ID',
            'city' => 'City',
            'name' => 'Name',
            'area' => 'Area',
            'address' => 'Address',
            'type_id' => 'Type ID',
            'image' => 'Image',
            'router' => 'Router',
            'map_pic' => 'Map Pic',
            'detail' => 'Detail',
            'contact' => 'Contact',
            'base_fee' => 'Base Fee',
            'principal' => 'Principal',
            'logo' => 'Logo',
            'owner' => 'Owner',
            'open_time' => 'Open Time',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'status' => 'Status',
        ];
    }
}
