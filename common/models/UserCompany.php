<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_company".
 *
 * @property int $id
 * @property int|null $user_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $name
 * @property string|null $address
 * @property string|null $contact_info
 *
 * @property User $user
 */
class UserCompany extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['name', 'contact_info'], 'string', 'max' => 150],
            [['address'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'name' => 'Name',
            'address' => 'Address',
            'contact_info' => 'Contact Info',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
