<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CoordinatorPrograms;

/**
 * CoordinatorProgramsSearch represents the model behind the search form of `common\models\CoordinatorPrograms`.
 */
class CoordinatorProgramsSearch extends CoordinatorPrograms
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'ref_program_id', 'ref_program_major_id'], 'safe'],
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
        $query = CoordinatorPrograms::find()->joinWith('user');

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
            // 'user_id' => $this->user_id,
            'ref_program_id' => $this->ref_program_id,
            'ref_program_major_id' => $this->ref_program_major_id,
        ]);

        if (!is_null($this->user_id)) {
            $searchArray = explode(' ', $this->user_id);
            foreach($searchArray as $info):
                $query->andFilterWhere(['or', 
                    ['like', 'user.fname', $info], 
                    ['like', 'user.mname', $info], 
                    ['like', 'user.sname', $info],
                ]);
            endforeach;
        }

        return $dataProvider;
    }
}
