<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "system_other_feature".
 *
 * @property int $id
 * @property string|null $feature
 * @property int $enabled
 */
class SystemOtherFeature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_other_feature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enabled'], 'required'],
            [['enabled'], 'integer'],
            [['feature'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'feature' => 'Feature',
            'enabled' => 'Enabled',
        ];
    }
}
