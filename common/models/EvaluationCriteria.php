<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evaluation_criteria".
 *
 * @property int $id
 * @property string|null $title
 * @property int $max_points
 *
 * @property EvaluationForm[] $evaluationForms
 */
class EvaluationCriteria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evaluation_criteria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['max_points'], 'required'],
            [['max_points'], 'integer'],
            [['title'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'max_points' => 'Max Points',
        ];
    }

    /**
     * Gets query for [[EvaluationForms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluationForms()
    {
        return $this->hasMany(EvaluationForm::class, ['evaluation_criteria_id' => 'id']);
    }
}
