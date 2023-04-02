<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\UserData;
use common\models\RefProgram;

/** @var yii\web\View $this */
/** @var common\models\CoordinatorPrograms $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="coordinator-programs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    // print_r($user_id); exit;
        $coordinators = ArrayHelper::map(UserData::find()
        ->select(['user.id','CONCAT(user.fname," ",user.sname) as fname'])
        ->joinWith('authAssignment')
        ->where(['auth_assignment.item_name' => 'OjtCoordinator'])
        ->andFilterWhere(['user.id' => $user_id])
        ->all(),'id','fname');

        $programs = ArrayHelper::map(RefProgram::find()->select(['id','CONCAT(title," [", abbreviation, "]") as title'])->all(),'id','title');
    ?>

    <?= $form->field($model, 'user_id')->dropDownList($coordinators, ['prompt' => '-','class' => 'form-control','disabled' => !empty($user_id) ? true : false]) ?>

    <?= $form->field($model, 'ref_program_id')->dropDownList($programs, ['prompt' => '-','class' => 'form-control']) ?>

    <?php // $form->field($model, 'ref_program_major_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
