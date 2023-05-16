<?php

namespace common\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\mail\BaseMailer;

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
            [['fname', 'sname','email'], 'required'],
            [['mname','password_hash','password_reset_token','verification_token','auth_key','password'],'safe'],
            [['fname'], 'string', 'max' => 250],
            [['mname'], 'string', 'max' => 150],
            [['sname'], 'string', 'max' => 50],
            [['sex'], 'string', 'max' => 1],
            // [['mobile_no'],'integer'],
            [['mobile_no','tel_no','suffix','item_name','bday'],'safe'],
            // [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            // [['auth_key'], 'string', 'max' => 32],
            [['student_idno'], 'unique'],
            [['username'], 'unique'],
            [['email'], 'unique'],
            ['email', 'email'],
            // ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            // [['password'],Yii::$app->controller->id == "user-management" && Yii::$app->controller->action->id == "create" ? 'required' : 'safe'],

            // TRAINEE REQUIRED FIELDS
            [['mobile_no','ref_program_id','ref_program_major_id','student_year','student_section','address'],'safe'],
            [['student_idno','email'], in_array(Yii::$app->request->get('account_type'),['trainee']) ? 'required' : 'unique'],

            [['student_idno'], 'required', 'when' => function ($model) { return $model->item_name == 'Trainee'; }, 'whenClient' => "function (attribute, value) { return $('#userdata-item_name').val() == 'Trainee'; }"],

            // LOGIN USER REQUIRED FIELDS
            [['company'],Yii::$app->user->can('Trainee') ? 'required' : 'safe'],
            [['ref_department_id'],Yii::$app->user->can('Trainee') ? 'required' : 'validateCompanyDepartment'],
            [['student_idno'],Yii::$app->user->can('Trainee') ? 'required' : 'unique'],
            [['ref_program_id'],Yii::$app->user->can('Trainee') ? 'required' : 'safe'],
            [['ref_program_major_id'],Yii::$app->user->can('Trainee') ? 'required' : 'safe'],
            [['student_year'],Yii::$app->user->can('Trainee') ? 'required' : 'safe'],
            [['student_section'],Yii::$app->user->can('Trainee') ? 'required' : 'safe'],
            [['bday'],Yii::$app->user->can('Trainee') ? 'required' : 'safe'],
            [['sex'],Yii::$app->user->can('Trainee') ? 'required' : 'safe'],
            [['address'],Yii::$app->user->can('Trainee') ? 'required' : 'safe'],
            [['mobile_no'],Yii::$app->user->can('Trainee') ? 'required' : 'safe'],
            [['email'],Yii::$app->user->can('Trainee') ? 'required' : 'unique'],
            [['username'],Yii::$app->user->can('Trainee') ? 'required' : 'unique'],
            

            // COMPANY SUPERVISOR FIELDS
            [['ref_position_id'],'safe'],
            [['company'], in_array(Yii::$app->request->get('account_type'),['companysupervisor']) ? 'required' : 'safe'],
            [['email'], in_array(Yii::$app->request->get('account_type'),['companysupervisor']) ? 'required' : 'unique'],

            [['company'], 'required', 'when' => function ($model) { return $model->item_name == 'CompanySupervisor'; }, 'whenClient' => "function (attribute, value) { return $('#userdata-item_name').val() == 'CompanySupervisor'; }"],
            [['email'], 'required', 'when' => function ($model) { return $model->item_name == 'CompanySupervisor'; }, 'whenClient' => "function (attribute, value) { return $('#userdata-item_name').val() == 'CompanySupervisor'; }"],
            

            [['ref_department_id'], 'validateCompanyDepartment'],

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

    /**
     * Sends an email using the Yii2 mailer component.
     * @param string $to the recipient email address
     * @param string $subject the email subject
     * @param string $body the email body
     * @param string $from the email address of the sender
     * @return bool whether the email was sent successfully
     * @throws InvalidConfigException if the mailer component is not configured correctly
     */
    function sendEmail($to, $subject, $body, $from)
    {
        /** @var BaseMailer $mailer */
        $mailer = Yii::$app->mailer;

        // Set the recipient email address, subject, and sender
        $message = $mailer->compose()
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->setFrom($from);

        // Attempt to send the email
        try {
            $sent = $message->send();
        } catch (\Exception $e) {
            $sent = false;
        }

        return $sent;
    }

    public function validateCompanyDepartment($attribute)
    {
        if(in_array(Yii::$app->request->get('account_type'),['companysupervisor']) || $this->item_name == "CompanySupervisor")
        {
            if(in_array(Yii::$app->controller->action->id,['create','update']))
            {
                $query = UserData::find()
                ->joinWith('userCompany')
                ->joinWith('authAssignment')
                ->where(['user_company.ref_company_id' => $this->company])
                ->andWhere(['auth_assignment.item_name' => 'CompanySupervisor'])
                ->andWhere(['user.ref_department_id' => $this->ref_department_id])->one();

                if(!empty($query->id))
                {
                    if($query->id == $this->id)
                    {
                        
                    }
                    else
                    {
                        if (UserData::find()
                        ->joinWith('userCompany')
                        ->joinWith('authAssignment')
                        ->where(['user_company.ref_company_id' => $this->company])
                        ->andWhere(['auth_assignment.item_name' => 'CompanySupervisor'])
                        ->andWhere(['user.ref_department_id' => $this->ref_department_id])->exists()) {
                            $this->addError($attribute, 'There is already Company Supervisor in this Department');
                        }
                    }
                }
                
            }
        }
    }

    public function FullName()
    {
        return $this->sname.", ".$this->fname;
    }

    public function getUserFullName()
    {
        return $this->fname." ".$this->mname." ".$this->sname;
    }

    public function getUserFullNameWithMiddleInitial()
    {
        return $this->fname." ".($this->getMiddleInitial($this->mname))." ".$this->sname;
    }

    public function getMiddleInitial($middleName)
    {
        $middleNameArray = explode(' ', trim($middleName));
        $middleInitial = '';
        foreach ($middleNameArray as $name) {
            $middleInitial .= strtoupper(substr($name, 0, 1)).".";
        }
        return !empty($middleName) ? $middleInitial : "";
    }

    public function getInitial($middleName)
    {
        $middleNameArray = explode(' ', trim($middleName));
        $middleInitial = '';
        foreach ($middleNameArray as $name) {
            $middleInitial .= strtoupper(substr($name, 0, 1));
        }
        return !empty($middleName) ? $middleInitial : '';
    }

     /**
     * Gets query for [[EvaluationForm]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluationForm()
    {
        return $this->hasOne(EvaluationForm::class, ['trainee_user_id' => 'id']);
    }

     /**
     * Gets query for [[CmsRole]].
     *
     * @return \yii\db\ActiveQuery
     */

      /**
     * Gets query for [[CmsRoleActions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoordinatorPrograms()
    {
        return $this->hasMany(CoordinatorPrograms::class, ['user_id' => 'id']);
    }


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

    /**
     * Gets query for [[CmsRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTimesheet()
    {
        return $this->hasOne(UserTimesheet::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserArchive]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserArchive()
    {
        return $this->hasMany(UserArchive::class, ['user_id' => 'id']);
    }

}
