<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Announcement $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="announcement-form" style="margin-bottom:20px;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'content_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'viewer_type')->dropDownList(['assigned_program' => 'Assigned Program/Course', 'all_program' => 'All Programs/Courses'], ['prompt' => '-','class' => 'form-control']) ?>

    <?php // $form->field($model, 'date_time')->textInput() ?>

    <div class="form-group" style="margin-top:50px;">
        <?= Html::submitButton('POST', ['class' => 'btn btn-warning', 'style' => 'width:100%;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
