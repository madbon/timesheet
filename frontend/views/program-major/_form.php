<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProgramMajor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="program-major-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ref_program_id')->dropDownList(
        $program,
        ['prompt'=>'Select option']
    ) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'abbreviation')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
