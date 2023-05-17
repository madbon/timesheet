<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EvaluationForm;

/**
 * EvaluationFormSearch represents the model behind the search form of `common\models\EvaluationForm`.
 */
class EvaluationFormSearch extends EvaluationForm
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'submission_thread_id', 'trainee_user_id', 'user_id', 'evaluation_criteria_id'], 'integer'],
            [['remarks'], 'safe'],
            [['points_scored'], 'number'],
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
        $query = EvaluationForm::find();

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
            'submission_thread_id' => $this->submission_thread_id,
            'trainee_user_id' => $this->trainee_user_id,
            'user_id' => $this->user_id,
            // 'date_commenced' => $this->date_commenced,
            // 'date_complete' => $this->date_complete,
            'evaluation_criteria_id' => $this->evaluation_criteria_id,
            'points_scored' => $this->points_scored,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
