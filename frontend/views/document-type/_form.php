<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\DocumentType $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="document-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'action_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'required_uploading')->dropDownList([0 => 'NO', 1 => 'YES'], ['prompt' => '-','class' => 'form-control'])->label("Transaction Type") ?>

    <?= $form->field($model, 'enable_tagging')->dropDownList([0 => 'NO', 1 => 'YES'], ['prompt' => '-','class' => 'form-control'])->label("Enable Tagging?") ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
