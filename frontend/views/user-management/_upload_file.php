<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserData $model */

$this->title = $message.': '.$model->fullName();
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-data-view">


    <h1><?= Html::encode($this->title) ?></h1>

    <div style='width:300px; height:300px; border:1px solid gray;' >
        <div class="d-flex justify-content-center align-items-center">
        <?php
            $uploadedFileName = Yii::$app->getModule('admin')->GetFileNameExt('UserData',$model->id);

            $uploadedFile = Yii::$app->getModule('admin')->GetFileUpload('UserData',$model->id);

            if(Yii::$app->getModule('admin')->FileExists($uploadedFileName)) 
            {
                echo Html::img(Yii::$app->request->baseUrl.$uploadedFile, ['alt'=>'My Image','height' => '300', 'width' => '300', 'style' => 'margin-bottom:20px;' ]);
            }
            else
            {
                echo "NO UPLOADED E-SIGNATURE";
            }
        ?>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <?= $form->field($modelUpload, 'imageFile')->fileInput(['class' => 'btn btn-sm btn-primary']) ?>

            <br/>
            <button class="btn btn-success"><?= Yii::$app->getModule("admin")->GetIcon("upload-cloud") ?> Upload</button>

            <?php ActiveForm::end() ?>
        </div>
    </div>

    