<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\AuthItemChild $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="auth-item-child-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'parent')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'parent')->dropDownList(
            $roleArr,
            [
                'prompt' => '-- SELECT ROLE --',
                'onchange' => '
                    $.post("' . Yii::$app->urlManager->createUrl('auth-item-child/get-available-permissions?name=') . '" + $(this).val(), function(data) {
                        $("#' . Html::getInputId($model, 'child') . '").html(data);
                    });
                '
            ]
    ) ?>

    <?php // $form->field($model, 'child')->textInput(['maxlength' => true]) ?>

    <?php 
        if(Yii::$app->controller->action->id == "update")
        {
            echo $form->field($model, 'child')->dropDownList(
                $permissionsArr + [$child => $child],
                ['prompt'=>'-- SELECT PERMISSION --']
            ); 
        }
        else
        {
            echo $form->field($model, 'child')->dropDownList(
                $permissionsArr,
                ['prompt'=>'-- SELECT PERMISSION --']
            ); 
        }
    
        
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
