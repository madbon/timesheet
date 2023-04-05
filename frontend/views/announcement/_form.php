<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\RefProgram;
use yii\helpers\ArrayHelper;


/** @var yii\web\View $this */
/** @var common\models\Announcement $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="announcement-form" style="margin-bottom:20px;">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'content_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?php
        $viewerType = [];
        if(Yii::$app->user->can('announcement-viewer-type-assigned-program'))
        {
            $viewerType += ['assigned_program' => 'ASSIGNED PROGRAM(S)/COURSE(S)'];
        }

        if(Yii::$app->user->can('announcement-viewer-type-select-programs'))
        {
            $viewerType += ['selected_program' => Yii::$app->controller->action->id == "update" ? 'SELECTED PROGRAMS/COURSES' : 'SELECT PROGRAM/COURSE'];
        }

        if(Yii::$app->user->can('announcement-viewer-type-all-programs'))
        {
            $viewerType += ['all_program' => 'ALL PROGRAMS/COURSES'];
        }

        // $viewerType = [
        //     'all_program' => 'All Programs/Courses',
        //     'selected_program' => Yii::$app->controller->action->id == "update" ? 'Selected Programs/Courses' : 'Select Programs/Courses',
        // ];
    ?>

    <?= $form->field($model, 'viewer_type')->dropDownList($viewerType,
        [
            'prompt' => '-',
            'onchange' => '
                // $.post("' . Yii::$app->urlManager->createUrl('/admin/default/get-major?program_id=') . '" + $(this).val(), function(data) {
                //     $("#' . Html::getInputId($model, 'ref_program_major_id') . '").html(data);
                // });
                if(this.value == "selected_program")
                {
                    $("#selected-programs").show(300);
                }
                else
                {
                    $("#selected-programs").hide(300);
                }
            '
        ]) ?>
        

    <div id="selected-programs" style="display:none;">
        <?= $form->field($model, 'selected_programs')->checkboxList(
            ArrayHelper::map(RefProgram::find()->select(['id','CONCAT("[",abbreviation,"] ",title) as title'])->all(),'id','title'),
            [
                'class' => 'form-control'
            ]
        ) ?>
    </div>

    <?= $form->field($modelUpload, 'imageFiles[]')->fileInput(['multiple' => true])->label('Add attachment/s') ?>

    

    <?php // $form->field($model, 'date_time')->textInput() ?>

    <div class="form-group" style="margin-top:50px;">
        <?= Html::submitButton(Yii::$app->controller->action->id == "index"  ? 'POST' : "UPDATE", ['class' => 'btn btn-warning', 'style' => 'width:100%;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
if($model->viewer_type === 'selected_program')
{ 
    $this->registerJs("
        $('#selected-programs').show();
    ");
} 
?>


