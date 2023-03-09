<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Files;
use Yii;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $model_name,$model_id,$file_name,$extension,$file_hash,$remarks,$created_at;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['model_name','model_id','file_name','extension','file_hash','remarks','created_at'],'safe'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $model = new Files();
            date_default_timezone_set("Asia/Manila");
            $datetimeInteger = time();

            $model->user_id = Yii::$app->user->identity->id;
            $model->model_name = $this->model_name;
            $model->model_id = $this->model_id;
            $model->file_name = $this->imageFile->baseName;
            $model->extension = $this->imageFile->extension;

            $compositionHash = Yii::$app->user->identity->id.$this->model_name.$this->model_id.$this->imageFile->baseName.$datetimeInteger;
            $hashValue = md5(Yii::$app->security->generatePasswordHash($compositionHash));

            $model->file_hash = $hashValue;
            $model->created_at = $datetimeInteger;

            if(Files::find()->where(['model_id' => $this->model_id, 'model_name' => $this->model_name])->exists())
            {
                
                $queryFileOne = Files::find()->where(['model_id' => $this->model_id, 'model_name' => $this->model_name])->one();

                $getFileName = $queryFileOne->file_hash.'.'.$queryFileOne->extension;

                 // Delete uploaded file if existing
                 
                // $file_path = Yii::getAlias('@frontend/web/uploads/') . $getFileName; 
                $file_path = Yii::getAlias('@webroot')."/uploads/".$getFileName;
                //assuming $file_name is the name of the file to be deleted

                if (file_exists($file_path)) {
                    unlink($file_path);
                    Files::deleteAll(['model_id' => $this->model_id, 'model_name' => $this->model_name]);
                    // file was successfully deleted
                } else {
                    // file does not exist
                }
            }
            else
            {

            }

           

            if($model->save())
            {
                $this->imageFile->saveAs('uploads/' . $hashValue.'.'.$this->imageFile->extension);
                return true;
            }
            else
            {
                return false;
            }
            
        } else {
            return false;
        }
    }
}