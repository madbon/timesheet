<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserTimesheetSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-timesheet-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'time_in_am') ?>

    <?= $form->field($model, 'time_out_am') ?>

    <?= $form->field($model, 'time_in_pm') ?>

    <?php // echo $form->field($model, 'time_out_pm') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
