<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SystemOtherFeature $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="system-other-feature-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'feature')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'enabled')->textInput() ?>

    <?= $form->field($model, 'enabled')->dropDownList(
        [1 => 'YES', 0 => 'NO'],
        ['prompt'=>'Select option']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
