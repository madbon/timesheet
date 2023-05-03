<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_document_type".
 *
 * @property int $id
 * @property string|null $title
 *
 * @property SubmissionThread[] $submissionThreads
 */
class DocumentType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_document_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','action_title'], 'string', 'max' => 150],
            [['required_uploading','enable_tagging','enable_commenting','required_remarks'],'integer'],
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
        ];
    }

    /**
     * Gets query for [[SubmissionThreads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubmissionThreads()
    {
        return $this->hasMany(SubmissionThread::class, ['ref_document_type_id' => 'id']);
    }
}
