<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $fname
 * @property string|null $mname
 * @property int|null $sname
 * @property string|null $bday
 * @property string|null $sex
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 */
class UserData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public $confirm_password,$password;
    public $program_id;
    public $major_id;
    public $item_name;
    public $company;

    public function rules()
    {   
        return [
            // [[ 'status', 'created_at', 'updated_at'], 'integer'],
            // [['bday'], 'safe'],
            [['fname', 'sname', 'email', 'sex','bday','username'], 'required'],
            [['mname','password_hash','password_reset_token','verification_token','auth_key'],'safe'],
            [['fname'], 'string', 'max' => 250],
            [['mname'], 'string', 'max' => 150],
            [['sname'], 'string', 'max' => 50],
            [['sex'], 'string', 'max' => 1],
            [['mobile_no'],'string','max' => 10],
            [['mobile_no','tel_no','suffix','item_name'],'safe'],
            // [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            // [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            ['email', 'email'],
            // ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            [['password'],Yii::$app->controller->id == "user-management" && Yii::$app->controller->action->id == "create" ? 'required' : 'safe'],

            // Create Trainee other required indicators
            [['student_idno','mobile_no','ref_program_id','ref_program_major_id','student_year','student_section','address'], in_array(Yii::$app->request->get('account_type'),['trainee']) ? 'required' : 'safe'],

            [['mobile_no','ref_program_id'], in_array(Yii::$app->request->get('account_type'),['ojtcoordinator']) ? 'required' : 'safe'],

            [['ref_department_id','ref_position_id'], in_array(Yii::$app->request->get('account_type'),['ojtcoordinator']) ? 'required' : 'safe'],

            [['ref_department_id'], in_array(Yii::$app->request->get('account_type'),['trainee']) ? 'required' : 'safe'],

            [['company'], in_array(Yii::$app->request->get('account_type'),['companysupervisor','trainee']) ? 'required' : 'safe'],

            [['company'], in_array(Yii::$app->request->get('account_type'),['companysupervisor','trainee']) ? 'required' : 'safe'],

            [['company'], 'required', 'when' => function ($model) { return $model->item_name == 'CompanySupervisor'; }, 'whenClient' => "function (attribute, value) { return $('#userdata-item_name').val() == 'CompanySupervisor'; }"],

            [['company'], 'required', 'when' => function ($model) { return $model->item_name == 'Trainee'; }, 'whenClient' => "function (attribute, value) { return $('#userdata-item_name').val() == 'Trainee'; }"],

            // [['company'], 'required'],
            
            // [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fname' => 'First Name',
            'mname' => 'Middle Name',
            'sname' => 'Last Name',
            'bday' => 'Birth Date',
            'sex' => 'Sex',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
            'confirm_password' => 'Confirm Password',
            'password' => 'Password',
            'student_idno' => 'Student ID',
            'ref_program_id' => 'Program/Course',
            'ref_program_major_id' => 'Course Major',
            'student_year' => 'Year',
            'student_section' => 'Section',
            'item_name' => 'Role',
            'ref_department_id' => 'Department',
            'ref_position_id' => 'Position',
            // 'role_name' => 'Role',
        ];
    }

    public function getFullName()
    {
        return $this->sname.", ".$this->fname;
    }

     /**
     * Gets query for [[CmsRole]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getUserCompany()
    {
        return $this->hasOne(UserCompany::class, ['user_id' => 'id']); 
    }

    public function getPosition()
    {
        return $this->hasOne(Position::class, ['id' => 'ref_position_id']); 
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'ref_department_id']); 
    }


    public function getProgramMajor()
    {
        return $this->hasOne(ProgramMajor::class, ['id' => 'ref_program_major_id']);
    }

    /**
     * Gets query for [[CmsRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(RefProgram::class, ['id' => 'ref_program_id']);
    }

    /**
     * Gets query for [[CmsRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoleAssignment()
    {
        return $this->hasOne(CmsRoleAssignment::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[CmsRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignment()
    {
        return $this->hasOne(AuthAssignment::class, ['user_id' => 'id']);
    }

}
