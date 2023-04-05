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
    public $date_time_picker,$selected_programs;
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['content_title', 'content', 'date_time','date_time_picker','selected_programs'], 'safe'],
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
        ->joinWith('announcementProgramTags')
        ->joinWith('user');

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

        // print_r($this->date_time); exit;

        // grid filtering conditions
        // $query->andFilterWhere([
        //     // 'id' => $this->id,
        //     // 'announcement.user_id' => $this->user_id,
        //     'announcement.date_time' => $this->date_time,
        // ]);

        

        $query->andFilterWhere(['announcement_program_tags.ref_program_id' => Yii::$app->getModule('admin')->GetAssignedProgram()]);

        if(Yii::$app->user->can('announcement-create'))
        {
            $query->orFilterWhere(['announcement.user_id' => Yii::$app->user->identity->id]);
        }

        $query->orFilterWhere(['announcement.viewer_type' => 'all_program']);

        

        if($this->selected_programs)
        {
            $query->andFilterWhere(['announcement_program_tags.ref_program_id' => $this->selected_programs]);
            $this->date_time = null;
        }

        if($this->content)
        {
            $searchArray = explode(' ', $this->content);
            foreach($searchArray as $info):
                $query->andFilterWhere(['or', 
                    ['like', 'user.fname', $info], 
                    ['like', 'user.mname', $info], 
                    ['like', 'user.sname', $info],
                    ['like', 'announcement.content_title', $info],
                    ['like', 'announcement.content', $info],
                ]);
            endforeach;

            $this->date_time = null;
            // $this->date_time_picker = null;
        }
        else
        {
            if($this->date_time_picker)
            {
                $query->andFilterWhere(['like','announcement.date_time',$this->date_time_picker]);
                $this->date_time = null;
            }
            else
            {
                // $this->date_time = !empty($this->date_time) ? $this->date_time : date("Y-m-d");

                if(!empty($this->date_time))
                {
                    if($this->date_time == "all-days")
                    {

                    }
                    else if($this->date_time == 'my-post')
                    {
                        $query->where(['announcement.user_id' => Yii::$app->user->identity->id]);
                    }
                    else if($this->date_time == 'yesterday')
                    {
                        $query->andFilterWhere(['like','announcement.date_time',date('Y-m-d', strtotime('-1 day'))]);
                    }
                    else if($this->date_time == 'today')
                    {
                        $query->andFilterWhere(['like','announcement.date_time',date('Y-m-d')]);
                    }
                    else
                    {
                        $query->andFilterWhere(['like','announcement.date_time',$this->date_time]);
                    }
                }
            }
        }

        
        
       

        $query->orderBy(['announcement.id' => SORT_DESC])->groupBy(['announcement.id']);

        // print_r($query->createCommand()->rawSql); exit;

        return $dataProvider;
    }
}
