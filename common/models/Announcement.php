<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "announcement".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $content_title
 * @property string|null $content
 * @property string|null $date_time
 *
 * @property User $user
 */
class Announcement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'announcement';
    }

    /**
     * {@inheritdoc}
     */

    public $selected_programs;
    public function rules()
    {
        return [
            [['viewer_type','content'],'required'],
            [['user_id'], 'integer'],
            [['content'], 'string'],
            [['date_time'], 'safe'],
            [['content_title'], 'string', 'max' => 250],
            [['selected_programs'], 'required', 'when' => function ($model) { return $model->viewer_type == 'selected_program'; }, 'whenClient' => "function (attribute, value) { return $('#announcement-viewer_type').val() == 'selected_program'; }"],
            // [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'content_title' => 'Title',
            'content' => 'Content',
            'date_time' => 'Date Time',
            'viewer_type' => 'Who can see this announcement?',
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnnouncementProgramTags()
    {
        return $this->hasMany(AnnouncementProgramTags::class, ['announcement_id' => 'id']);
    }
}
