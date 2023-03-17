<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_timesheet".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $time_in_am
 * @property string|null $time_out_am
 * @property string|null $time_in_pm
 * @property string|null $time_out_pm
 * @property string|null $date
 * @property string|null $remarks
 */
class UserTimesheet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_timesheet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['time_in_am', 'time_out_am', 'time_in_pm', 'time_out_pm', 'date'], 'safe'],
            [['remarks'], 'string', 'max' => 50],
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
            'time_in_am' => 'Time In Am',
            'time_out_am' => 'Time Out Am',
            'time_in_pm' => 'Time In Pm',
            'time_out_pm' => 'Time Out Pm',
            'date' => 'Date',
            'remarks' => 'Remarks',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(UserData::class, ['id' => 'user_id']); 
    }
}
