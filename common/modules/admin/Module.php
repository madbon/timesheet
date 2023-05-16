<?php

namespace common\modules\admin;

use common\models\Announcement;
use common\models\AnnouncementProgramTags;
use common\models\Files;
use common\models\UserData;
use common\models\UserCompany;
use common\models\AuthAssignment;
use common\models\DocumentAssignment;
use common\models\DocumentType;
use common\models\SubmissionThread;
use common\models\SubmissionThreadSeen;
use common\models\CoordinatorPrograms;
use common\models\ProgramMajor;
use common\models\RefProgram;
use common\models\SubmissionReply;
use common\models\SubmissionReplySeen;
use common\models\SubmissionThreadSearch;
use common\models\SystemOtherFeature;
use common\models\AnnouncementSeen;
use common\models\SubmissionArchive;
use yii\helpers\FormatConverter;
use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public static function isTaskArchive($submission_thread_id, $user_id)
    {
        if(SubmissionArchive::find()->where(['submission_thread_id' => $submission_thread_id, 'user_id' => $user_id])->exists())
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public static function arrayNumber($value)
    {
        $numbers = []; // Initialize an empty array

        for ($i = 1; $i <= $value; $i++) {
            $numbers[$i] = $i; // Add the current number to the array
        }

        return $numbers;
    }

    public static function calculateLateness($time_in)
    {
        $targetTime = strtotime('8:00 AM'); // Convert the target time to a timestamp
        $currentTime = strtotime($time_in); // Get the current time as a timestamp

        // Exclude the minutes between 12:00 PM and 1:00 PM from the lateness calculation
        if (date('G', $currentTime) >= 12 && date('G', $currentTime) < 13) {
            $currentTime = strtotime('12:00 PM');
        }
    
        // Check if the current time is after the target time
        if ($currentTime > $targetTime) {
            $lateness = $currentTime - $targetTime;

            if (date('G', $currentTime) >= 13) {
                $lateness = ($currentTime - $targetTime) - 3600;
            }
             // Calculate the lateness in seconds
    
            // Convert the lateness to hours and minutes
            $latenessHours = floor($lateness / 3600);
            $latenessMinutes = intval(($lateness % 3600) / 60);
    
            return [
                'hours' => $latenessHours,
                'minutes' => $latenessMinutes,
            ];
        }
    
        return [
            'hours' => 0,
            'minutes' => 0,
        ]; // Return 0 hours and 0 minutes if the current time is before the target time
    }

    public static function getDayOfWeek($date)
    {
        $timestamp = strtotime($date);
        $dayOfWeek = date('N', $timestamp);

        // Day of week: 1 (Monday) to 7 (Sunday)
        switch ($dayOfWeek) {
            case 6:
                return 'Sat';
            case 7:
                return 'Sun';
            default:
                return '';
        }
    }

    public static function isWeekend($date)
    {
        
        // $timestamp = strtotime(FormatConverter::toDate($date, 'yyyy-MM-dd'));
        $timestamp = strtotime($date);
        $dayOfWeek = date('N', $timestamp);
    
        // Day of week: 1 (Monday) to 7 (Sunday)
        return $dayOfWeek >= 6; // Return true if day is Saturday or Sunday
    }

    // public static function requiredRemarks()
    // {
    //     $query = DocumentType::find()->where([''])
    // }

    public static function sendMail($email,$fullname,$username,$password)
    {
        $to = $email;
        $subject = 'Your registration details for BPSU OJT Timesheet Monitoring System for CICT Trainees';
        $body = '<pre>
<p>Dear '.($fullname).', 

    We are pleased to inform you that your account has been successfully created in our system. Here are your login details:

Username: '.($username).'
Password: '.($password).'
            
Please keep these details safe and do not share them with anyone. You can log in to our system at https://bpsutimesheet.online using the above credentials.
            
Please note that for security reasons, we recommend that you change your password after your first login. You can do this by going to My Account > Login Credentials.
            
In addition, we encourage you to update your personal details to ensure that our records are accurate and up to date.
            
If you have any questions or concerns, please do not hesitate to contact us.
            
Thank you!
            
Best regards,
<strong>Bataan Peninsula State University</strong>



<strong>This is a system-generated email. Please do not reply.</strong>



<strong>DISCLAIMER:</strong>

This email and its contents are confidential and intended solely for the individual or entity to whom it is addressed. If you are not the intended recipient, please notify us immediately and delete this email from your system. Any unauthorized use, disclosure, or distribution of this email is strictly prohibited.

            </p></pre>';
        $from = 'management@bpsutimesheet.online';

        $model = new UserData();

        if ($model->sendEmail($to, $subject, $body, $from)) {
            echo 'Email sent successfully!';
        } else {
            echo 'Failed to send email.';
        }
    }

    public static function unseenAnnouncement($date = null)
    {
        $annTags = AnnouncementProgramTags::find()
        ->select(['announcement_program_tags.announcement_id'])
        ->joinWith('announcement')
        ->where(['announcement_program_tags.ref_program_id' => Yii::$app->getModule('admin')->GetAssignedProgram()])
        ->andFilterWhere(['LIKE','announcement.date_time', $date])
        ->all();
        // ->createCommand()->rawSql;

        // print_r($annTags); exit;

        $arrAnnIds = [];
        $countUnseen = 0;
        foreach ($annTags as $tag) {
            $arrAnnIds[] = $tag->announcement_id;
            if(!AnnouncementSeen::find()->where(['announcement_id' => $tag->announcement_id, 'user_id' => Yii::$app->user->identity->id])->exists())
            {
                $countUnseen += 1;
            }
        }

        // print_r($arrAnnIds); exit;

        $allProgramAnn = Announcement::find()
        ->where(['viewer_type' => 'all_program'])
        ->andFilterWhere(['LIKE','date_time', $date])
        ->all();

        foreach ($allProgramAnn as $allProg) {
            if(!AnnouncementSeen::find()->where(['announcement_id' => $allProg->id, 'user_id' => Yii::$app->user->identity->id])->exists())
            {
                $countUnseen += 1;
            }
        }

        

       return $countUnseen;
    }

    public static function systemOtherFeature($feature){
        $query = SystemOtherFeature::find()->where(['feature' => $feature])->one();

        return !empty($query->enabled) ? $query->enabled : 0;
    }

    public static function getProgram($program_id)
    {
        $query = RefProgram::find()->where(['id' => $program_id])->one();

        return !empty($query->title) ? $query->title : NULL;
    }

    public static function getMajorCode($major_abbrev,$program_id)
    {
        $query = ProgramMajor::find()->where(['abbreviation' => $major_abbrev, 'ref_program_id' => $program_id])->one();

        return !empty($query->id) ? $query->id : NULL;
    }

    public static function haveFaceRegistered($user_id)
    {
       if(Files::find()->where(['model_id' => $user_id, 'model_name' => 'UserFacialRegister'])->exists())
       {
            return 1;
       }
       else
       {
            return 0;
       }
    }

    public static function submissionReplySeen()
    {
        $searchModel = new SubmissionThreadSearch();
        $searchModel->ref_document_type_id = 3;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        $documentType = [];
        if($dataProvider->query->all())
        {
            foreach ($dataProvider->query->all() as $model) {  
                $value = '';
                $storeUserIds = [];
                $documentType = [];
    
                if($model->submissionReply)
                {
                    foreach ($model->submissionReply as $reply) {
                        $storeUserIds = [];
                        // $documentType = [];
                        foreach ($reply->submissionReplySeen as $seen) {
                            
                            if($seen->submission_reply_id == $reply->id)
                            {
                                $storeUserIds[] = $seen->user_id;
                                $documentType[] = $seen->submissionThread->ref_document_type_id;
                                
                            }
                            else
                            { 
                                $documentType[] = $seen->submissionThread->ref_document_type_id;
                                
                            }
                            
                        }
                    }
    
                   if(in_array(Yii::$app->user->identity->id,$storeUserIds))
                   {
                        return [
                            'countTaskReplySeen' => 0,
                            'countArReplySeen' => 0,
                            'countEvalReplySeen' => 0,
                            'countActReminderReplySeen' =>0,
                            2 => 0,
                            6 => 0,
                            10 => 0,
                        ];
                   }
                   else
                   {
                        return [
                            'countTaskReplySeen' => 1,
                            'countArReplySeen' => in_array(3,$documentType) ? 1 : 0,
                            'countEvalReplySeen' => in_array(1,$documentType) ? 1 : 0,
                            'countActReminderReplySeen' => in_array(5,$documentType) ? 1 : 0,
                            2 => in_array(1,$documentType) ? 1 : 0,
                            6 => in_array(3,$documentType) ? 1 : 0,
                            10 => in_array(5,$documentType) ? 1 : 0,
                        ];
                   }
    
                    // return implode(',',$storeUserIds);
                }
                else
                {
                    return [
                        'countTaskReplySeen' => 0,
                        'countArReplySeen' => 0,
                        'countEvalReplySeen' => 0,
                        'countActReminderReplySeen' =>0,
                        2 => 0,
                        6 => 0,
                        10 => 0,
                    ];
                }
            }

           
        }
        else
        {
            return [
                'countTaskReplySeen' => 0,
                'countArReplySeen' => 0,
                'countEvalReplySeen' => 0,
                'countActReminderReplySeen' => 0,
                2 => 0,
                6 => 0,
                10 => 0,
            ];
        }

       
        
    }

    public static function submissionThreadSeen()
    {

        $documentAssignment = DocumentAssignment::find()
        ->select(['ref_document_type_id'])
        ->where(['auth_item' => Yii::$app->getModule('admin')->getLoggedInUserRoles()])
        ->andWhere(['type' => 'RECEIVER'])
        ->all();

        $countTask = 0;
        $countAr = 0;
        $countEval = 0;
        $countActReminder = 0;

        $countTaskReplySeen = 0;
        $countArReplySeen = 0;
        $countEvalReplySeen = 0;
        $countActReminderReplySeen = 0;
        $arrSample = [];
        $storeUserIds = [];

        foreach ($documentAssignment as $row) {
            $qrySubThread = SubmissionThread::find()
            ->select(['submission_thread.id','submission_thread.ref_document_type_id'])
            ->joinWith(Yii::$app->getModule('admin')->documentTypeAttrib($row->ref_document_type_id,'enable_tagging') ? 'taggedUser' : 'user')
            ->joinWith('userCompany')
            ->joinWith('documentAssignment')
            ->where(['ref_document_assignment.auth_item' => Yii::$app->getModule('admin')->getLoggedInUserRoles()])
            ->andWhere(['ref_document_assignment.ref_document_type_id' => $row->ref_document_type_id])
            ->andWhere(['ref_document_assignment.type' => 'RECEIVER']);
            // ->count();

            if(Yii::$app->getModule('admin')->TaskFilterType($row->ref_document_type_id,Yii::$app->getModule('admin')->getLoggedInUserRoles(),'based_on_login_id'))
            {
                if($row->ref_document_type_id == 3) // ACCOMPLISHMENT REPORT
                {
                    $qrySubThread->andFilterWhere(['user.id' => Yii::$app->user->identity->id]);
                }
            }

            // if($this->ref_document_type_id == 3) // ACCOMPLISHMENT REPORT
            if(Yii::$app->getModule('admin')->TaskFilterType($row->ref_document_type_id,Yii::$app->getModule('admin')->getLoggedInUserRoles(),'based_on_course'))
            {
                $qrySubThread->andFilterWhere(['user.ref_program_id' => Yii::$app->getModule('admin')->GetAssignedProgram()]);
                $qrySubThread->andFilterWhere(['user_company.ref_company_id' => Yii::$app->getModule('admin')->GetCompanyBasedOnCourse()]);
                $qrySubThread->andFilterWhere(['user.ref_department_id' => Yii::$app->getModule('admin')->GetDepartmentBasedOnCourse()]);
            }

            // if($this->ref_document_type_id == 5) // ACTIVITY REMINDERS
            if(Yii::$app->getModule('admin')->TaskFilterType($row->ref_document_type_id,Yii::$app->getModule('admin')->getLoggedInUserRoles(),'based_on_company_department'))
            {
                $qrySubThread->andFilterWhere(['user.ref_department_id' => Yii::$app->getModule('admin')->GetAssignedDepartment()]);
                $qrySubThread->andFilterWhere(['user_company.ref_company_id'=> Yii::$app->getModule('admin')->GetAssignedCompany()]);
            }

            foreach ($qrySubThread->groupBy(['submission_thread.id'])->all() as $thread) {
                if(!SubmissionThreadSeen::find()
                ->where(['user_id' => Yii::$app->user->identity->id])
                ->andWhere(['submission_thread_id' => $thread->id])->exists())
                {
                    $countTask  += 1;
                    
                    if($thread->ref_document_type_id == 1) // Eval Form
                    {
                        $countEval += 1;
                    }

                    if($thread->ref_document_type_id == 3) // Accomplishment Report
                    {
                        $countAr += 1;
                    }

                    if($thread->ref_document_type_id == 5) // Activity Reminder
                    {
                        $countActReminder += 1;
                    }
                }

            }

            
            
        }


        return [
            'countTask' => $countTask,
            'countAr' => $countAr,
            'countEval' => $countEval,
            'countActReminder' => $countActReminder,
            'countTaskReplySeen' => $countTaskReplySeen,
            'countArReplySeen' => $countArReplySeen,
            'countEvalReplySeen' => $countEvalReplySeen,
            'countActReminderReplySeen' => $countActReminderReplySeen,
            1 => $countEval,
            3 => $countAr,
            5 => $countActReminder,
            2 => $countEvalReplySeen,
            6 => $countArReplySeen,
            10 => $countActReminderReplySeen,
        ];
    }

    public static function TaskFilterType($ref_document_type_id,$role=[],$filter_type)
    {
        $docAss = DocumentAssignment::find()->where([
            'ref_document_type_id' => $ref_document_type_id, 
            'auth_item' => $role,
            'filter_type' => $filter_type,
            ])->one();
       
        return !empty($docAss->filter_type) ? $docAss->filter_type : NULL;
    }

    public static function documentTypeAttrib($id,$attrib)
    {
        $query = DocumentType::findOne(['id' => $id]);

        return !empty($query[$attrib]) ? $query[$attrib] : null;
    }

    public static function documentAssignedAttrib($id,$type)
    {
        $query = DocumentAssignment::find()->where(['ref_document_type_id' => $id, 'auth_item' => Yii::$app->getModule('admin')->getLoggedInUserRoles(), 'type' => $type])->one();

        // print_r($query); exit;

        return !empty($query->type) ? $query->type : null;
    }

    public static function getLoggedInUserRoles() {
        $roles = [];
    
        if (!Yii::$app->user->isGuest) {
            $authManager = Yii::$app->authManager;
            $userRoles = $authManager->getRolesByUser(Yii::$app->user->id);
    
            if (!empty($userRoles)) {
                $roles = \yii\helpers\ArrayHelper::getColumn($userRoles, 'name');
            }
        }
    
        return $roles;
    }

    public static function GetSupervisorByTraineeUserId($trainee_user_id)
    {
        $getCompany = UserCompany::findOne(['user_id' => $trainee_user_id]);
        $company = !empty($getCompany->ref_company_id) ? $getCompany->ref_company_id : NULL;

        $getUserIdsInCompany = UserCompany::find()
        ->joinWith('users')
        ->where(['user_company.ref_company_id' => $company])
        ->andWhere(['user.status' => 10])
        ->andWhere(['NOT',['.user_company.user_id' => NULL]])
        ->all();

        $userIds = [];

        foreach ($getUserIdsInCompany as $key => $row) {
            $userIds[] = $row['user_id'];
        }

        $query = AuthAssignment::find()->where(['user_id' => $userIds, 'item_name' => 'CompanySupervisor'])->one();

        $getSupervisorId = !empty($query->user_id) ? $query->user_id : null;

        $user = UserData::findOne(['id' => $getSupervisorId]);

        return !empty($user->userFullNameWithMiddleInitial) ? $user->userFullNameWithMiddleInitial : "NO COMPANY SUPERVISOR ASSIGNED";
        
    }

    public static function GetSupervisorIdByTraineeUserId($trainee_user_id)
    {
        // print_r($trainee_user_id); exit;
        $getCompany = UserCompany::findOne(['user_id' => $trainee_user_id]);
        $company = !empty($getCompany->ref_company_id) ? $getCompany->ref_company_id : NULL;

        $getUserIdsInCompany = UserCompany::find()->where(['ref_company_id' => $company])->all();

        $userIds = [];

        foreach ($getUserIdsInCompany as $key => $row) {
            $userIds[] = $row['user_id'];
        }

        $query = AuthAssignment::find()->where(['user_id' => $userIds, 'item_name' => 'CompanySupervisor'])->one();

        $getSupervisorId = !empty($query->user_id) ? $query->user_id : null;

        $user = UserData::findOne(['id' => $getSupervisorId]);

        return !empty($user->id) ? $user->id : null;
        
    }

    public static function AssignedProgramTitle()
    {
        $query = UserData::find()
        ->joinWith('program')
        ->where(['user.id' => Yii::$app->user->identity->id])->one();

        return !empty($query->program->title) ? $query->program->title : "NOTHING";
    }

    public static function AssignedCompany()
    {
        $query = UserData::find()
        ->joinWith('userCompany.company')
        ->where(['user.id' => Yii::$app->user->identity->id])->one();

        return !empty($query->userCompany->company->name) ? $query->userCompany->company->name : "NOTHING";
    }

    public static function AssignedDepartment()
    {
        $query = UserData::find()
        ->joinWith('department')
        ->where(['user.id' => Yii::$app->user->identity->id])->one();

        return !empty($query->department->title) ? $query->department->title : "NOTHING";
    }

    public static function GetAssignedProgram()
    {
        $query = UserData::find()->where(['id' => Yii::$app->user->identity->id])->one();

        if(CoordinatorPrograms::find()
        ->where(['user_id' => Yii::$app->user->identity->id])->exists())
        {
            $coorAssignedProgram = \yii\helpers\ArrayHelper::getColumn(CoordinatorPrograms::find()
            ->where(['user_id' => Yii::$app->user->identity->id])
            ->all(),'ref_program_id');

            // print_r($coorAssignedProgram); exit;

            return $coorAssignedProgram;
        }
        else
        {
            return !empty($query->ref_program_id) ? $query->ref_program_id : NULL;
        }
    }

    public static function GetDepartmentBasedOnCourse()
    {
        $query = UserData::find()->where(['ref_program_id' => Yii::$app->getModule('admin')->GetAssignedProgram()])->all();

        $departmentIds = [];

        foreach ($query as $key => $row) {
            $departmentIds[] = $row['ref_department_id'];
        }

        return $departmentIds;
    }

    public static function truncateText($text, $limit = 25, $ellipsis = '...') {
        $words = explode(' ', $text);
    
        if (count($words) > $limit) {
            $truncatedWords = array_slice($words, 0, $limit);
            $text = implode(' ', $truncatedWords) . $ellipsis;
        }
    
        return $text;
    }

    public static function GetCompanyBasedOnCourse()
    {
        $query = UserData::find()->where(['ref_program_id' => Yii::$app->getModule('admin')->GetAssignedProgram()])->all();

        $students = [];

        foreach ($query as $key => $row) {
            $students[] = $row['id'];
        }


        $userCompany = UserCompany::find()->where(['user_id' => $students])->all();

        $companies = [];

        foreach ($userCompany as $key2 => $row2) {
            $companies[] = $row2['ref_company_id'];
        }

        return $companies;
    }

    public static function GetAssignedDepartment()
    {
        $query = UserData::find()->where(['id' => Yii::$app->user->identity->id])->one();

        return !empty($query->ref_department_id) ? $query->ref_department_id : NULL;
    }

    public static function GetAssignedCompany()
    {
        $query = UserCompany::find()->where(['user_id' => Yii::$app->user->identity->id])->one();

        return !empty($query->ref_company_id) ? $query->ref_company_id : NULL;
    }

    public static function GetIcon($name)
    {

        switch ($name) {
            case 'upload-cloud':
                $name = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-upload-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0z"/>
              </svg>';
            break;
            case 'person-plus-fill':
                $name = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
              </svg>';
            break;
            case 'geo-alt-fill':
                $name = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
              </svg>';
            break;
            
            default:
                # code...
            break;
        }

        return $name;
    }

    public static function GetFileUpload($model_name,$id)
    {
        $model = Files::find()->where(['model_name' => $model_name, 'model_id' => $id])->orderBy(['id' => SORT_DESC])->one();

        return !empty($model->file_name) ? '/uploads/'.$model->file_hash.'.'.$model->extension : 'noimage.png';
    }

    public static function GetFacialRegister($model_name,$id)
    {
        $model = Files::find()->where(['model_name' => $model_name, 'model_id' => $id])->orderBy(['id' => SORT_DESC])->one();

        return !empty($model->file_hash) ? $model->file_hash : 'noimage.png';
    }

    public static function GetFileNameExt($model_name,$id)
    {
        $model = Files::find()->where(['model_name' => $model_name, 'model_id' => $id])->orderBy(['id' => SORT_DESC])->one();

        return !empty($model->file_name) ? $model->file_hash.'.'.$model->extension : 'noimage.png';
    }

    public static function FileExistsByQuery($model_name,$model_id)
    {
        $isExists = 0;
        if(Files::find()->where(['model_name' => $model_name, 'model_id' => $model_id])->exists())
        {
            $query = Files::find()->where(['model_name' => $model_name, 'model_id' => $model_id])->one();

            $fileHash = !empty($query->file_hash) ? $query->file_hash : 'nohash';
            $fileExt = !empty($query->extension) ? $query->extension : 'jpg';

            $file_hash_ext =$fileHash.'.'.$fileExt;
            
            if($file_hash_ext)
            {
                $file_path = Yii::getAlias('@webroot')."/uploads/".$file_hash_ext;
                if (file_exists($file_path)) {
                    $isExists = 1;
                }
            }
        } 

        return $isExists;
    }

    public static function FileExists($file_hash_ext)
    {
        $isExists = 0;
        if($file_hash_ext)
        {
        
            $file_path = Yii::getAlias('@webroot')."/uploads/".$file_hash_ext;
            if (file_exists($file_path)) {
                $isExists = 1;
            }
        }

        return $isExists;
    }




}
