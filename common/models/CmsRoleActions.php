<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_role_actions".
 *
 * @property int $id
 * @property int|null $cms_role_id
 * @property int|null $cms_actions_id
 *
 * @property CmsActions $cmsActions
 * @property CmsRole $cmsRole
 */
class CmsRoleActions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_role_actions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cms_role_id', 'cms_actions_id'], 'integer'],
            [['cms_role_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsRole::class, 'targetAttribute' => ['cms_role_id' => 'id']],
            [['cms_actions_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsActions::class, 'targetAttribute' => ['cms_actions_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cms_role_id' => 'Cms Role ID',
            'cms_actions_id' => 'Cms Actions ID',
        ];
    }

    /**
     * Gets query for [[CmsActions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCmsActions()
    {
        return $this->hasOne(CmsActions::class, ['id' => 'cms_actions_id']);
    }

    /**
     * Gets query for [[CmsRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCmsRole()
    {
        return $this->hasOne(CmsRole::class, ['id' => 'cms_role_id']);
    }
}
