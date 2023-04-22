<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_archive".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $user_status
 * @property string|null $date_time
 */
class UserArchive extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_archive';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_status'], 'integer'],
            [['date_time'], 'safe'],
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
            'user_status' => 'User Status',
            'date_time' => 'Date Time',
        ];
    }
}
