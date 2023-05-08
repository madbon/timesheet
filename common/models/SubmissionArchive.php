<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "submission_archive".
 *
 * @property int $id
 * @property int|null $submission_thread_id
 * @property int|null $user_id
 * @property string|null $date_time
 *
 * @property SubmissionThread $submissionThread
 * @property User $user
 */
class SubmissionArchive extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'submission_archive';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['submission_thread_id', 'user_id'], 'integer'],
            [['date_time'], 'safe'],
            [['submission_thread_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubmissionThread::class, 'targetAttribute' => ['submission_thread_id' => 'id']],
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
            'submission_thread_id' => 'Submission Thread ID',
            'user_id' => 'User ID',
            'date_time' => 'Date Time',
        ];
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
