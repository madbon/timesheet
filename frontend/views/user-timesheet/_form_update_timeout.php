<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserTimesheet $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-timesheet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'time_in_am')->textInput(['type' => 'time']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'time_out_am')->textInput(['type' => 'time']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'time_in_pm')->textInput(['type' => 'time']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'time_out_pm')->textInput(['type' => 'time']) ?>
        </div>
    </div>

    <?= $form->field($model, 'date')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'remarks')->hiddenInput(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
