<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\DocumentAssignment $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="document-assignment-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'ref_document_type_id')->dropDownList($documentType, ['prompt' => '-','class' => 'form-control'])->label("Transaction Type") ?>

    <?= $form->field($model, 'type')->dropDownList(['RECEIVER' => 'RECEIVER', 'SENDER' => 'SENDER'], ['prompt' => '-','class' => 'form-control'])->label("TYPE") ?>

    <?= $form->field($model, 'auth_item')->dropDownList($authItem, ['prompt' => '-','class' => 'form-control'])->label("ROLE") ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
