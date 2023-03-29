<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "submission_reply".
 *
 * @property int $id
 * @property int|null $submission_thread_id
 * @property int|null $user_id
 * @property string|null $message
 * @property string|null $date_time
 */
class SubmissionReply extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'submission_reply';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['submission_thread_id', 'user_id'], 'integer'],
            [['message'], 'string'],
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
            'submission_thread_id' => 'Submission Thread ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'date_time' => 'Date Time',
        ];
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
