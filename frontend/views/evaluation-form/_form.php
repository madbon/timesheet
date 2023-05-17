<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EvaluationForm $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="evaluation-form-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'submission_thread_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'trainee_user_id')->hiddenInput()->label(false) ?>

    <?=  $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <?php //  $form->field($model, 'date_commenced')->hiddenInput()->label(false) ?>

    <?php //  $form->field($model, 'date_complete')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'evaluation_criteria_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'points_scored')->dropDownList(Yii::$app->getModule('admin')->arrayNumber($model->evaluationCriteria->max_points), ['prompt' => '-','class' => 'form-control']) ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
