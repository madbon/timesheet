<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_year".
 *
 * @property int $year
 * @property string|null $title
 */
class StudentYear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_year';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'required'],
            [['year'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['year'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'year' => 'Year',
            'title' => 'Title',
        ];
    }
}
