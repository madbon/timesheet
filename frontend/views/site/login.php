<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm; 

$this->title = 'LOGIN';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    body {
        background-image: url(<?= Yii::$app->request->baseUrl . '/ref/images/login_bg.jpg' ?>);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        background-attachment: fixed;
    }

    div.row .col-sm-6 a.btn
    {
        background:none;
        border:none;
        color:#c0c0c0;
        text-transform: uppercase;
        font-weight: bold;
    }

    div.row .col-sm-6
    {
        background:#ddd;
        border:none;
        text-align:center; 
        vertical-align:middle; 
        padding:2px;
    }

    div.row .col-sm-6.active-link
    {
        background:none;
        border:none;
    }

    div.row .col-sm-6.active-link a
    {
        color:black;
    }

    div.row .col-sm-6 a.btn:hover
    {
        background:none;
        color:gray;
    }

    div.row .col-sm-6.active-link a:hover
    {
        color:black;
    }
    footer.footer
    {
        /* background:#ff000061; */
        background: none;
    }
    footer.footer p
    {
        color:white;
        margin-top:15px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.9);
        text-align: center;
    }
</style>

<div class="site-login" >
    <div class="container d-flex justify-content-center align-items-center">
        <!-- <div class="card" >
            <div class="card-body" style="padding:0;"> -->
                <div>
                
                
                <div style="padding:10px; ">
                    <div style="margin-bottom:20px;">
                        <div class="d-flex justify-content-center align-items-center">
                            <!-- <div style="background:white;"> -->
                                <?php  
                                    $imageUrl = Yii::$app->request->baseUrl . '/ref/images/logo_unclear.png';

                                    echo Html::img($imageUrl, ['alt' => 'Example Image','style' => 'filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5));','width' => 180, 'height' => 260]);
                                ?>
                            <!-- </div> -->
                        </div>
                    </div>

                    
                    
                    <div style="border:1px solid #ddd; padding:10px; padding-top:0px; border-radius:5px; background:#ffffffc7;">

                        <p style="text-align: center; font-weight:normal; font-size:15px; color:#ae0505; padding:5px; padding-right:50px; padding-left:50px; padding-top:30px; padding-bottom:30px;">OJT Timesheet Monitoring System for CICT Trainees</p>
                        
                        <div class="card-body">
                            
                            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Username, student ID, or email'])->label(false) ?>

                                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

                                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                                <div class="form-group">
                                    <?= Html::submitButton('LOGIN <i class="fas fa-sign-in-alt"></i>', ['class' => 'btn btn-danger', 'name' => 'login-button', 'style' => 'width:100%; border-radius:25px;']) ?>
                                </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>
</div>



