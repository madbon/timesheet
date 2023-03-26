<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_document_type".
 *
 * @property int $id
 * @property int|null $title
 * @property string|null $type Receiver or Sender
 * @property string|null $auth_item_name
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
            [['title'], 'string'],
            [['type'], 'string', 'max' => 10],
            [['auth_item_name'], 'string', 'max' => 50],
            [['auth_item_name','type','title'],'unique','targetAttribute' => ['auth_item_name','type','title']],
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
            'type' => 'Type',
            'auth_item_name' => 'Auth Item Name',
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
