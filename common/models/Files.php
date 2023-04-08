<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $model_name
 * @property int|null $model_id
 * @property string|null $file_name
 * @property string|null $extension
 * @property string|null $file_hash
 * @property string|null $remarks
 * @property int|null $created_at
 *
 * @property User $user
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'model_id', 'created_at'], 'integer'],
            [['remarks'], 'string'],
            [['model_name'], 'string', 'max' => 50],
            [['file_name'], 'string', 'max' => 250],
            [['extension'], 'string', 'max' => 10],
            [['file_hash'], 'string', 'max' => 150],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'model_name' => 'Model Name',
            'model_id' => 'Model ID',
            'file_name' => 'File Name',
            'extension' => 'Extension',
            'file_hash' => 'File Hash',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

     /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserData()
    {
        return $this->hasOne(UserData::class, ['id' => 'user_id']);
    }
}
