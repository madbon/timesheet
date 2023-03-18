<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserData;
use Yii;

/**
 * UserDataSearch represents the model behind the search form of `common\models\UserData`.
 */
class UserDataSearch extends UserData
{
    /**
     * {@inheritdoc}
     */
    public $item_name;
    public $company;
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['fname','sname', 'mname', 'bday', 'sex', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'verification_token','ref_program_id','ref_program_major_id','student_idno','student_year','student_section','item_name','suffix','mobile_no','tel_no','address','company','ref_department_id','ref_position_id'], 'safe'],
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
        

        $query = UserData::find()
        ->joinWith('authAssignment.itemName')
        ->joinWith('userCompany.company');

       // add left join with AuthItem model

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10, // limit the number of items per page to 10
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
            'id' => $this->id,
            'sname' => $this->sname,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'mobile_no' => $this->mobile_no,
            'tel_no' => $this->tel_no,
        ]);

        $query->andFilterWhere(['like', 'fname', $this->fname])
            ->andFilterWhere(['like', 'mname', $this->mname])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'suffix', $this->suffix])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like','bday',$this->bday])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['=', 'ref_program_id', $this->ref_program_id])
            ->andFilterWhere(['=', 'ref_program_major_id', $this->ref_program_major_id])
            ->andFilterWhere(['=', 'student_year', $this->student_year])
            ->andFilterWhere(['=', 'student_section', $this->student_section])
            ->andFilterWhere(['=', 'student_idno', $this->student_idno])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token])
            ->andFilterWhere(['=', 'ref_position_id', $this->ref_position_id])
            ->andFilterWhere(['=', 'ref_department_id', $this->ref_department_id]);

            $query->andFilterWhere(['=','ref_department_id', Yii::$app->getModule('admin')->GetAssignedDepartment()]);

            $query->andFilterWhere(['=','user_company.ref_company_id', Yii::$app->getModule('admin')->GetAssignedCompany()]);

            if($this->item_name)
            {
                $this->item_name = $this->item_name;
            }
            else
            {
               $this->item_name = "Trainee";
            }

            if(Yii::$app->user->can('OjtCoordinator'))
            {
                if($this->item_name == "CompanySupervisor")
                {
                    $query->andFilterWhere(['user_company.ref_company_id' => Yii::$app->getModule('admin')->GetCompanyBasedOnCourse()]);
                }
                else if($this->item_name == "Trainee")
                {
                    $query->andFilterWhere(['=','ref_program_id', Yii::$app->getModule('admin')->GetAssignedProgram()]);
                }
            }

            

            $query->andFilterWhere(['like', 'auth_item.name', $this->item_name]);

            $query->andFilterWhere(['like','ref_company.name',$this->company]);


            // print_r($query->createCommand()->rawSql); exit;

        return $dataProvider;
    }
}
