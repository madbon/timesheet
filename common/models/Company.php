<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_company".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $contact_info
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['latitude', 'longitude'], 'number'],
            [['name', 'address'], 'string', 'max' => 255],
            [['contact_info'], 'string', 'max' => 150],
            ['latitude', 'unique'],
            ['longitude', 'unique'],
            ['address', 'unique'],
            [['latitude','longitude','address','name'],'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Company Name',
            'address' => 'Company Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'contact_info' => 'Contact Info',
        ];
    }
}
