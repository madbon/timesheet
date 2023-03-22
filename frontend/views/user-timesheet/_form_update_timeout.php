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

    <?php 
        echo $form->field($model, 'time_in_am')->textInput(); 

        echo $form->field($model, 'time_out_am')->textInput();

        echo $form->field($model, 'time_in_pm')->textInput(); 
        echo $form->field($model, 'time_out_pm')->textInput();
        
    ?>

    <?= $form->field($model, 'date')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'remarks')->hiddenInput(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
