<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "announcement_program_tags".
 *
 * @property int $id
 * @property int|null $announcement_id
 * @property int|null $ref_program_id
 */
class AnnouncementProgramTags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'announcement_program_tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['announcement_id', 'ref_program_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'announcement_id' => 'Announcement ID',
            'ref_program_id' => 'Ref Program ID',
        ];
    }
}
