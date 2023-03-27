<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SubmissionThread;
use common\models\DocumentType;

/**
 * SubmissionThreadSearch represents the model behind the search form of `common\models\SubmissionThread`.
 */
class SubmissionThreadSearch extends SubmissionThread
{
    /**
     * {@inheritdoc}
     */
    public $type;
    public function rules()
    {
        return [
            [['id', 'user_id', 'ref_document_type_id', 'created_at'], 'integer'],
            [['remarks','type'], 'safe'],
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
        $query = SubmissionThread::find()
        ->joinWith('documentType');

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

        $user_id = \Yii::$app->user->identity->id;

        $authAssignment = AuthAssignment::find()->where(['user_id' => $user_id])->one();

        // print_r(DocumentType::find()->where(['auth_item_name' => $authAssignment->item_name, 'type' => 'SENDER'])->createCommand()->rawSql); exit;

        $documentTypeSubmitted = DocumentType::find()->where(['auth_item_name' => $authAssignment->item_name])->one();

        $this->ref_document_type_id = !empty($this->ref_document_type_id) ? $this->ref_document_type_id : $documentTypeSubmitted->id;

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'ref_document_type_id' => $this->ref_document_type_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks]);

        // $query->andFilterWhere(['=', 'ref_document_type.id', $this->type]);

        // print_r($query->createCommand()->rawSql); exit;

        return $dataProvider;
    }
}
