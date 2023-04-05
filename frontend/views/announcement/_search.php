<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\RefProgram;

/** @var yii\web\View $this */
/** @var common\models\AnnouncementSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="announcement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?php // $form->field($model, 'user_id') ?>

    <?php // $form->field($model, 'content_title') ?>

    <div class="row">
        <div class="col-sm-8">
            <?= $form->field($model, 'content')->textInput(['placeholder' => 'Search..'])->label(false) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'date_time_picker')->textInput(['type' => 'date'])->label(false) ?>
        </div>
    </div>

    <?php if(Yii::$app->user->can('announcement-search-program')){ ?>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'selected_programs')->checkboxList(
                    ArrayHelper::map(RefProgram::find()->select(['id','abbreviation'])->all(),'id','abbreviation'),
                    [
                        'class' => 'form-control'
                    ]
                )->label(false) ?>
            </div>
        </div>
    <?php } ?>

    

    <?= $form->field($model, 'date_time')->hiddenInput()->label(false) ?>

    

    <div class="form-group">
        <?= Html::submitButton('<i class="fas fa-search"></i> Search', ['class' => 'btn btn-primary btn-sm', 'style' => 'border-radius:25px;']) ?>
        <?= Html::a('<i class="fas fa-sync-alt"></i> Reset', ['index','AnnouncementSearch[date_time]' => 'today'], ['class' => 'btn btn-outline-secondary btn-sm','style' => 'border-radius:25px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
