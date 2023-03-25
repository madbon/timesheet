<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'RECORD YOUR TIME IN & TIME OUT';
?>
<div class="site-login">

    <div class="mt-5 offset-lg-3 col-lg-6">
        <h3 style="text-align:center;"><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(['id' => 'timein-form', 'options' => ['autocomplete' => 'off'],]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'autocomplete' => 'off']) ?>

            <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'off']) ?>

            <?php // $form->field($model, 'rememberMe')->checkbox() ?>

            <?php
                $this->registerJs('
                    $("#loginform-username").val("uname");
                    $("#loginform-password").val("");
                ');
            ?>

            <div class="form-group" style="text-align: center;">
                <?= Html::submitButton('Click here to record your time: '.'<span style="font-weight:bold;" id="clock"></span>', ['class' => 'btn btn-outline-success btn-block', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
        
    </div>
</div>
