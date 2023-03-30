<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SubmissionThread;
use common\models\DocumentType;
use common\models\DocumentAssignment;
use Yii;

/**
 * SubmissionThreadSearch represents the model behind the search form of `common\models\SubmissionThread`.
 */
class SubmissionThreadSearch extends SubmissionThread
{
    /**
     * {@inheritdoc}
     */
    public $type;
    public $program,$company,$department;
    public function rules()
    {
        return [
            [['id', 'ref_document_type_id', 'created_at'], 'integer'],
            [['remarks','type','subject','date_time','user_id','program','company','department','tagged_user_id'], 'safe'],
            [['date_time'], 'date', 'format' => 'php:Y-m-d'],
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
        $this->load($params);

        if(Yii::$app->getModule('admin')->documentTypeAttrib($this->ref_document_type_id,'enable_tagging'))
        {
            $query = SubmissionThread::find()
            ->joinWith('documentType')
            ->joinWith('taggedUser')
            ->joinWith('userCompany');
        }
        else
        {
            $query = SubmissionThread::find()
            ->joinWith('documentType')
            ->joinWith('user')
            ->joinWith('userCompany');
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       
        $queryDocAss = DocumentAssignment::find()->where(['auth_item' => Yii::$app->getModule('admin')->getLoggedInUserRoles()])->all();

        $docAss = [];
        foreach ($queryDocAss as $key => $row) {
            $docAss[] = $row['ref_document_type_id'];
        }

        $this->ref_document_type_id = !empty($this->ref_document_type_id) ? $this->ref_document_type_id : "X";

        // grid filtering conditions
        $query->andFilterWhere([
            // 'id' => $this->id,
            // 'user_id' => $this->user_id,
            'ref_document_type_id' => $this->ref_document_type_id,
        ]);

        $query->andFilterWhere(['ref_document_type_id' => $docAss]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks]);

        $query->andFilterWhere(['like', 'subject', $this->subject]);

        $query->andFilterWhere(['like', 'date_time', $this->date_time]);

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

        if (!is_null($this->tagged_user_id)) {
            $searchArray2 = explode(' ', $this->tagged_user_id);
            foreach($searchArray2 as $info2):
                $query->andFilterWhere(['or', 
                    ['like', 'user.fname', $info2], 
                    ['like', 'user.mname', $info2], 
                    ['like', 'user.sname', $info2],
                ]);
            endforeach;
        }

        // if(Yii::$app->user->can('Trainee'))
        if(Yii::$app->getModule('admin')->TaskFilterType($this->ref_document_type_id,Yii::$app->getModule('admin')->getLoggedInUserRoles(),'based_on_login_id'))
        {
            // if($this->ref_document_type_id == 3) // ACCOMPLISHMENT REPORT
            // {
                $query->andFilterWhere(['user.id' => Yii::$app->user->identity->id]);
            // }
        }

        // if($this->ref_document_type_id == 3) // ACCOMPLISHMENT REPORT
        if(Yii::$app->getModule('admin')->TaskFilterType($this->ref_document_type_id,Yii::$app->getModule('admin')->getLoggedInUserRoles(),'based_on_course'))
        {
            $query->andFilterWhere(['user.ref_program_id' => Yii::$app->getModule('admin')->GetAssignedProgram()]);
            $query->andFilterWhere(['user_company.ref_company_id' => Yii::$app->getModule('admin')->GetCompanyBasedOnCourse()]);
            $query->andFilterWhere(['user.ref_department_id' => Yii::$app->getModule('admin')->GetDepartmentBasedOnCourse()]);
        }

        // if($this->ref_document_type_id == 5) // ACTIVITY REMINDERS
        if(Yii::$app->getModule('admin')->TaskFilterType($this->ref_document_type_id,Yii::$app->getModule('admin')->getLoggedInUserRoles(),'based_on_company_department'))
        {
            $query->andFilterWhere(['user.ref_department_id' => Yii::$app->getModule('admin')->GetAssignedDepartment()]);
            $query->andFilterWhere(['user_company.ref_company_id'=> Yii::$app->getModule('admin')->GetAssignedCompany()]);
        }


        $query->andFilterWhere(['user.ref_program_id' => $this->program]);
        $query->andFilterWhere(['user_company.ref_company_id' => $this->company]);
        $query->andFilterWhere(['user.ref_department_id' => $this->department]);

        $query->orderBy(['id' => SORT_DESC]);

        // $query->andFilterWhere(['=', 'ref_document_type.id', $this->type]);

        // print_r($query->createCommand()->rawSql); exit;

        return $dataProvider;
    }
}
