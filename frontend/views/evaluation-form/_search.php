<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EvaluationFormSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="evaluation-form-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'submission_thread_id') ?>

    <?= $form->field($model, 'trainee_user_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'date_commenced') ?>

    <?php // echo $form->field($model, 'date_complete') ?>

    <?php // echo $form->field($model, 'evaluation_criteria_id') ?>

    <?php // echo $form->field($model, 'points_scored') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
