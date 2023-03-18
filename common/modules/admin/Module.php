<?php

namespace common\modules\admin;
use common\models\Files;
use common\models\UserData;
use common\models\UserCompany;
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

        return !empty($query->ref_program_id) ? $query->ref_program_id : NULL;
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
        $model = Files::find()->where(['model_name' => $model_name, 'model_id' => $id])->one();

        return !empty($model->file_name) ? '/uploads/'.$model->file_hash.'.'.$model->extension : 'noimage.png';
    }

    public static function GetFileNameExt($model_name,$id)
    {
        $model = Files::find()->where(['model_name' => $model_name, 'model_id' => $id])->one();

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
