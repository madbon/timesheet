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
    public $month,$month_id,$year,$month_val,$year_val;
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['time_in_am', 'time_out_am', 'time_in_pm', 'time_out_pm', 'date','status'], 'safe'],
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
            'user_id' => 'NAME',
            'time_in_am' => 'IN (am)',
            'time_out_am' => 'OUT (am)',
            'time_in_pm' => 'IN (pm)',
            'time_out_pm' => 'OUT (pm)',
            'date' => 'Date',
            'remarks' => 'Remarks',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(UserData::class, ['id' => 'user_id']); 
    }

    public static function getModelByDate($date)
    {
        $model = static::findOne(['date' => $date]);
        return $model;
    }
}
