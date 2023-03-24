<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\RefProgram $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ref-program-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'abbreviation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'required_hours')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
