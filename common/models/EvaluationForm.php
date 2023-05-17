<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evaluation_form".
 *
 * @property int $id
 * @property int|null $submission_thread_id
 * @property int|null $trainee_user_id
 * @property int|null $user_id
 * @property string|null $date_commenced
 * @property string|null $date_complete
 * @property int|null $evaluation_criteria_id
 * @property float|null $points_scored
 * @property string|null $remarks
 *
 * @property EvaluationCriteria $evaluationCriteria
 * @property SubmissionThread $submissionThread
 * @property User $traineeUser
 * @property User $user
 */
class EvaluationForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evaluation_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['submission_thread_id', 'trainee_user_id', 'user_id', 'evaluation_criteria_id'], 'integer'],
            // [['date_commenced', 'date_complete'], 'safe'],
            [['points_scored'], 'number'],
            [['points_scored'],'required'],
            [['remarks'], 'string', 'max' => 255],
            [['evaluation_criteria_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluationCriteria::class, 'targetAttribute' => ['evaluation_criteria_id' => 'id']],
            [['trainee_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['trainee_user_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['submission_thread_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubmissionThread::class, 'targetAttribute' => ['submission_thread_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'submission_thread_id' => 'Submission Thread ID',
            'trainee_user_id' => 'Trainee User ID',
            'user_id' => 'User ID',
            // 'date_commenced' => 'Date Commenced',
            // 'date_complete' => 'Date Complete',
            'evaluation_criteria_id' => 'Evaluation Criteria ID',
            'points_scored' => 'Points Scored',
            'remarks' => 'Remarks',
        ];
    }

    /**
     * Gets query for [[EvaluationCriteria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluationCriteria()
    {
        return $this->hasOne(EvaluationCriteria::class, ['id' => 'evaluation_criteria_id']);
    }

    /**
     * Gets query for [[SubmissionThread]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubmissionThread()
    {
        return $this->hasOne(SubmissionThread::class, ['id' => 'submission_thread_id']);
    }

    /**
     * Gets query for [[TraineeUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTraineeUser()
    {
        return $this->hasOne(UserData::class, ['id' => 'trainee_user_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserData::class, ['id' => 'user_id']);
    }
}
