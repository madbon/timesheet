<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Time In/Out Portal';
?>
<div class="site-login">

    <div class="mt-5 offset-lg-3 col-lg-6">
        

        <div style="margin-bottom:20px;">
            <div class="d-flex justify-content-center align-items-center">
                <?php  
                    $imageUrl = Yii::$app->request->baseUrl . '/ref/images/logo_university.png';

                    echo Html::img($imageUrl, ['alt' => 'Example Image','style' => 'filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5));']);
                ?>
            </div>
        </div>

        <h3 style="text-align:center;">OJT <?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'autocomplete' => 'off']) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?php // $form->field($model, 'rememberMe')->checkbox() ?>

            <?php
                $this->registerJs('
                    $("#loginform-username").val("uname");
                ');
            ?>

            <div class="form-group" style="text-align: center;">
                <?= Html::submitButton('Click here or Press Enter to record your time: '.'<span style="font-weight:bold;" id="clock"></span>', ['class' => 'btn btn-outline-success btn-block', 'name' => 'login-button', 'style' => 'border-radius:25px;']) ?>
            </div>

        <?php ActiveForm::end(); ?>
        
    </div>
</div>
