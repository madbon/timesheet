<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Files;
use Yii;

class UploadMultipleForm extends Model
{
    /**
     * @var UploadedFile
     */
    // public $imageFile;
    public $model_name,$model_id,$file_name,$extension,$file_hash,$remarks,$created_at;
    public $imageFiles;
    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => Yii::$app->controller->action->id == "update" ? true : false, 'extensions' => 'png, jpg, jpeg, gif, pdf, docx, xlsx, xls', 'maxFiles' => 10,'maxSize' => 5 * 1024 * 1024, 'tooBig' => 'Maximum file size is less than 5MB'],
            [['model_name','model_id','file_name','extension','file_hash','remarks','created_at'],'safe'],
            [['model_name','file_name','extension','file_hash','remarks'],'safe'],
            [['model_name','file_name','extension','file_hash','remarks'],'string'],
            [['model_id','created_at'],'integer'],
        ];
    }


    public function uploadMultiple()
    {
        if ($this->validate()) {
            $success = true;

            // Assume imageFiles is an array of uploaded files
            foreach ($this->imageFiles as $imageFile) {
                $model = new Files();
                date_default_timezone_set("Asia/Manila");
                $datetimeInteger = time();

                $model->user_id = Yii::$app->user->identity->id;
                $model->model_name = $this->model_name;
                $model->model_id = $this->model_id;
                $model->file_name = $imageFile->baseName;
                $model->extension = $imageFile->extension;

                $compositionHash = (Yii::$app->user->identity->id) . "-" . ($this->model_name) . "-" . ($this->model_id) . ($imageFile->baseName) . "-" . ($datetimeInteger);
                $hashValue = md5($compositionHash);

                $model->file_hash = $hashValue;
                $model->created_at = $datetimeInteger;

                if ($model->save(false)) {
                    $imageFile->saveAs('uploads/' . $hashValue . '.' . $imageFile->extension);
                } else {
                    $success = false;
                    break;
                }
            }

            return $success;
        } else {
            return false;
        }
    }

}