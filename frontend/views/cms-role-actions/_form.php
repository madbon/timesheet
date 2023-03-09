<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\CmsRoleActions $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cms-role-actions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cms_role_id')->textInput() ?>

    <?= $form->field($model, 'cms_actions_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
