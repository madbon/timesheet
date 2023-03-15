<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Company $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
        <?= $form->field($model, 'address')->textarea(['maxlength' => true, 'rows' => 2]) ?>
        </div>
        <div class="col-sm-3">
        <?= $form->field($model, 'contact_info')->textarea(['maxlength' => true, 'rows' => 2]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-3">
            <label>Latitude: <code id="label-latitude">
                <?php
                    if(Yii::$app->controller->action->id == "update")
                    {
                        echo !empty($model->latitude) ? $model->latitude : "-";
                    }
                ?>
            </code></label>
            <?= $form->field($model, 'latitude')->hiddenInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-sm-3">
            <label>Longitude: <code id="label-longitude">
                <?php
                    if(Yii::$app->controller->action->id == "update")
                    {
                        echo !empty($model->longitude) ? $model->longitude : "-";
                    }
                ?>
            </code></label>
            <?= $form->field($model, 'longitude')->hiddenInput(['maxlength' => true])->label(false) ?>
        </div>
    </div>
    

    


    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
