<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_program".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $abbreviation
 *
 * @property PostTags[] $postTags
 * @property UserProgram[] $userPrograms
 */
class RefProgram extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_program';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 250],
            [['abbreviation'], 'string', 'max' => 20],
            [['required_hours'],'integer'],
            [['title','required_hours'],'required'],
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
            'abbreviation' => 'Abbreviation',
        ];
    }

    /**
     * Gets query for [[PostTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTags::class, ['ref_program_id' => 'id']);
    }

    /**
     * Gets query for [[UserPrograms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPrograms()
    {
        return $this->hasMany(UserProgram::class, ['ref_program_id' => 'id']);
    }
}
