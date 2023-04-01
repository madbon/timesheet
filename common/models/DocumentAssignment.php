<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_document_assignment".
 *
 * @property int $id
 * @property int|null $ref_document_type_id
 * @property string|null $auth_item
 * @property string|null $type
 */
class DocumentAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $title,$action_title,$required_uploading,$docu_id,$docu_title;
    public static function tableName()
    {
        return 'ref_document_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref_document_type_id','auth_item','type','filter_type'],'required'],
            [['ref_document_type_id'], 'integer'],
            [['auth_item'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 20],
            [['filter_type'], 'string', 'max' => 150],
            [['auth_item','ref_document_type_id','type'],'unique','targetAttribute' => ['auth_item','ref_document_type_id','type']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_document_type_id' => 'Transaction Type',
            'auth_item' => 'Role',
            'type' => 'Type',
        ];
    }

    public function getDocumentType()
    {
        return $this->hasOne(DocumentType::class, ['id' => 'ref_document_type_id']);
    }
}
