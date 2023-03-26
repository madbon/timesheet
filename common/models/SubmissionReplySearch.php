<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SubmissionReply;

/**
 * SubmissionReplySearch represents the model behind the search form of `common\models\SubmissionReply`.
 */
class SubmissionReplySearch extends SubmissionReply
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'submission_thread_id', 'user_id'], 'integer'],
            [['message', 'date_time'], 'safe'],
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
        $query = SubmissionReply::find();

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
            'user_id' => $this->user_id,
            'date_time' => $this->date_time,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
