<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_program_major".
 *
 * @property int $id
 * @property int|null $ref_program_id
 * @property string|null $title
 * @property string|null $abbreviation
 *
 * @property PostTags[] $postTags
 * @property UserProgram[] $userPrograms
 */
class ProgramMajor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_program_major';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref_program_id'], 'integer'],
            [['title'], 'string', 'max' => 250],
            [['abbreviation'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_program_id' => 'Program/Course',
            'title' => 'Major Title',
            'abbreviation' => 'Major Abbreviation',
        ];
    }


    public function getProgram()
    {
        return $this->hasOne(RefProgram::class, ['id' => 'ref_program_id']);
    }

    /**
     * Gets query for [[PostTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTags::class, ['ref_program_major_id' => 'id']);
    }

    /**
     * Gets query for [[UserPrograms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPrograms()
    {
        return $this->hasMany(UserProgram::class, ['ref_program_major_id' => 'id']);
    }
}
