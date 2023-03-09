<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var common\models\UserData $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row" style="margin-bottom: 20px;">
        <div class="col-sm-6"">
        <?= $form->field($model, 'role_id')->dropDownList(
            $roleArr,
            ['prompt'=>'Select option']
        ) ?>
        </div>
    </div>
    
    <div style="margin-bottom: 20px; border:1px solid #ddd; padding:10px; background:white;">
        <div class="card-body">
        
            <h5 class="card-title">Personal Information</h5>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'sname')->textInput() ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'bday')->textInput(['type' => 'date', 'max' => (date('Y') - 10).date('-m-d')]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'sex')->dropDownList(
                        ['M' => 'Male', 'F' => 'Female'],
                        ['prompt'=>'Select option']
                    ) ?>
                </div>
                
            </div>
        </div>
    </div>

    

    <div style="border:1px solid #ddd; padding:10px; background:white;">
        <div class="card-body">
            <h5 class="card-title">Login Credentials</h5>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
                    <?php // $form->field($model, 'confirm_password')->textInput(['maxlength' => true]) ?>
                </div>
            </div>   
        </div>
    </div>

    <div class="form-group" style="margin-top: 10px;">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
