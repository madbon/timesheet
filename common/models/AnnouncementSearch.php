<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Announcement;
use Yii;

/**
 * AnnouncementSearch represents the model behind the search form of `common\models\Announcement`.
 */
class AnnouncementSearch extends Announcement
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['content_title', 'content', 'date_time'], 'safe'],
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
        $query = Announcement::find()
        ->joinWith('announcementProgramTags');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'id' => $this->id,
            // 'announcement.user_id' => $this->user_id,
            'announcement.date_time' => $this->date_time,
        ]);

        $query->andFilterWhere(['like', 'announcement.content_title', $this->content_title])
            ->andFilterWhere(['like', 'announcement.content', $this->content]);

        $query->andFilterWhere(['announcement_program_tags.ref_program_id' => Yii::$app->getModule('admin')->GetAssignedProgram()]);

        if(Yii::$app->user->can('announcement-create'))
        {
            $query->orFilterWhere(['announcement.user_id' => Yii::$app->user->identity->id]);
        }

        $query->orFilterWhere(['announcement.viewer_type' => 'all_program']);
       

        $query->orderBy(['announcement.id' => SORT_DESC])->groupBy(['announcement.id']);

        // print_r($query->createCommand()->rawSql); exit;

        return $dataProvider;
    }
}
