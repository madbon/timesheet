<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SubmissionThread $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="submission-thread-form">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'ref_document_type_id')->dropDownList($documentType, ['prompt' => 'Select transaction type', 'class' => 'form-control'])->label("Type of Transaction") ?>

            <?= $form->field($model, 'subject')->textInput() ?>

            <?= $form->field($model, 'remarks')->textarea(['rows' => 3]) ?>

            

            <div style="border:2px solid #ddd; padding:10px; margin-top:15px; background:white; border-radius:5px;">
                <p>
                    <code><strong>Acccepted File format:</strong> png, jpg</code><br/>
                    <code><strong>Max file size:</strong> Less than 5MB</code><br/>
                    <code><strong>Max no. of files per upload:</strong> 5 files</code>
                </p>
                <hr>
                <?= $form->field($modelUpload, 'imageFiles[]')->fileInput(['multiple' => true]) ?>
            </div>

            <?php // $form->field($model, 'ref_document_type_id')->textInput() ?>

            <?php // $form->field($model, 'created_at')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Submit/Create', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

   

</div>
