<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_department".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $abbreviation
 *
 * @property PostTags[] $postTags
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 250],
            [['abbreviation'], 'string', 'max' => 20],
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
        return $this->hasMany(PostTags::class, ['ref_department_id' => 'id']);
    }
}
