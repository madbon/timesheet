<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $student_idno
 * @property int|null $student_year
 * @property string|null $student_section
 * @property int|null $ref_program_id
 * @property int|null $ref_program_major_id
 * @property int|null $ref_department_id
 * @property int|null $ref_position_id
 * @property string|null $fname
 * @property string|null $mname
 * @property string|null $sname
 * @property string|null $suffix
 * @property string|null $bday
 * @property string|null $sex
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int|null $mobile_no
 * @property string $tel_no
 * @property string|null $address
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property Announcement[] $announcements
 * @property Files[] $files
 * @property SubmissionThread[] $submissionThreads
 * @property UserCompany[] $userCompanies
 */
class UserImport extends \yii\db\ActiveRecord
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
    public function rules()
    {
        return [
            [['student_year', 'ref_program_id', 'ref_program_major_id', 'ref_department_id', 'ref_position_id', 'mobile_no', 'status', 'created_at', 'updated_at'], 'integer'],
            [['bday'], 'safe'],
            // [['username', 'auth_key', 'password_hash', 'email', 'tel_no', 'created_at', 'updated_at'], 'required'],
            [['address'], 'safe'],
            [['student_idno', 'sname'], 'safe'],
            [['student_section', 'sex'], 'safe'],
            [['fname'], 'safe'],
            [['mname', 'tel_no'], 'safe'],
            [['suffix'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
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
            'student_idno' => 'Student Idno',
            'student_year' => 'Student Year',
            'student_section' => 'Student Section',
            'ref_program_id' => 'Ref Program ID',
            'ref_program_major_id' => 'Ref Program Major ID',
            'ref_department_id' => 'Ref Department ID',
            'ref_position_id' => 'Ref Position ID',
            'fname' => 'Fname',
            'mname' => 'Mname',
            'sname' => 'Sname',
            'suffix' => 'Suffix',
            'bday' => 'Bday',
            'sex' => 'Sex',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'mobile_no' => 'Mobile No',
            'tel_no' => 'Tel No',
            'address' => 'Address',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * Gets query for [[Announcements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnnouncements()
    {
        return $this->hasMany(Announcement::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(Files::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[SubmissionThreads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubmissionThreads()
    {
        return $this->hasMany(SubmissionThread::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserCompanies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCompanies()
    {
        return $this->hasMany(UserCompany::class, ['user_id' => 'id']);
    }
}
