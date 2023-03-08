<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_role".
 *
 * @property int $id
 * @property string|null $title
 *
 * @property CmsRoleActions[] $cmsRoleActions
 */
class CmsRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 50],
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
     * Gets query for [[CmsRoleActions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCmsRoleActions()
    {
        return $this->hasMany(CmsRoleActions::class, ['cms_role_id' => 'id']);
    }
}
