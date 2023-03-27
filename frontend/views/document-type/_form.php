<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\DocumentType $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="document-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?php // $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(['RECEIVER' => 'RECEIVER', 'SENDER' => 'SENDER'], ['prompt' => '-','class' => 'form-control'])->label("TYPE") ?>

    <?= $form->field($model, 'auth_item_name')->dropDownList($authItem, ['prompt' => '-','class' => 'form-control'])->label("ROLE") ?>

    <?= $form->field($model, 'required_uploading')->dropDownList(['YES' => 'YES', 'NO' => 'NO'], ['prompt' => '-','class' => 'form-control'])->label("Required Uploading of Files?") ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
