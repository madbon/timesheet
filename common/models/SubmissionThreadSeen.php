<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "submission_thread_seen".
 *
 * @property int $id
 * @property int|null $submission_thread_id
 * @property int|null $user_id
 */
class SubmissionThreadSeen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'submission_thread_seen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['submission_thread_id', 'user_id'], 'integer'],
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
