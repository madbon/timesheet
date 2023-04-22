<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserData $model */

// $this->title = $message.': '.$model->fullName();
// $this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index','UserDataSearch[item_name]' => 'Trainee']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
#uploadform-imagefile
{
    width: 100%;
}
#img-cont
{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 300px;
    background-color: white;
    color:gray;
}
</style>

<div class="user-data-view">

    <h1>My Profile Picture</h1>

    <div id="img-cont" style='width:300px; border:1px solid #ddd; margin-bottom:10px;'>
        <div>
        <?php
            $uploadedFileName = Yii::$app->getModule('admin')->GetFileNameExt('ProfilePhoto',$model->id);

            $uploadedFile = Yii::$app->getModule('admin')->GetFileUpload('ProfilePhoto',$model->id);

            if(Yii::$app->getModule('admin')->FileExists($uploadedFileName)) 
            {
                echo Html::img(Yii::$app->request->baseUrl.$uploadedFile, ['alt'=>'My Image', 'style' => 'width:100%; height:100%;', 'class' => 'img-responsive']);
            }
            else
            {
                echo "--NO PROFILE PHOTO--";
            }
        ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div style="border:2px solid #ddd; padding:10px;">
                    <p>
                        <code><strong>Acccepted File format:</strong> png, jpg</code><br/>
                        <code><strong>Max file size:</strong> Less than 5MB</code>
                    </p>
                    <hr>
                <!-- <div class="card-body"> -->
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                    <?= $form->field($modelUpload, 'imageFile')->fileInput(['class' => 'btn btn-outline-primary'])->label(false) ?>

                    <br/>
                    <button class="btn btn-success"><?= Yii::$app->getModule("admin")->GetIcon("upload-cloud") ?> Upload</button>

                    <?php ActiveForm::end() ?>
                <!-- </div> -->
            </div>
        </div>
    </div>
    

    