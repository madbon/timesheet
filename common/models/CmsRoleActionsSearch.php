<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CmsRoleActions;

/**
 * CmsRoleActionsSearch represents the model behind the search form of `common\models\CmsRoleActions`.
 */
class CmsRoleActionsSearch extends CmsRoleActions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cms_role_id', 'cms_actions_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CmsRoleActions::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cms_role_id' => $this->cms_role_id,
            'cms_actions_id' => $this->cms_actions_id,
        ]);

        return $dataProvider;
    }
}
