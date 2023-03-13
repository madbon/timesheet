<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_section".
 *
 * @property string $section
 */
class StudentSection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['section'], 'required'],
            [['section'], 'string', 'max' => 5],
            [['section'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'section' => 'Section',
        ];
    }
}
