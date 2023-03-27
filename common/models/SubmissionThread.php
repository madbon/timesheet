<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "submission_thread".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $remarks
 * @property int|null $ref_document_type_id
 * @property int|null $created_at
 *
 * @property RefDocumentType $refDocumentType
 * @property User $user
 */
class SubmissionThread extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'submission_thread';
    }

    /**
     * {@inheritdoc}
     */
    // public $imageFile;
    public function rules()
    {
        return [
            // [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, pdf','maxSize' => 5 * 1024 * 1024, 'tooBig' => 'Maximum file size is less than 5MB'],
            [['ref_document_type_id'],'required'],
            [['user_id', 'ref_document_type_id', 'created_at'], 'integer'],
            [['remarks'], 'string'],
            [['subject'], 'string','max' => 250],
            [['date_time'],'safe'],
            // [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            // [['ref_document_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefDocumentType::class, 'targetAttribute' => ['ref_document_type_id' => 'id']],
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
            'remarks' => 'Remarks',
            'ref_document_type_id' => 'Type of Transaction',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[RefDocumentType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentType()
    {
        return $this->hasOne(DocumentType::class, ['id' => 'ref_document_type_id']);
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
