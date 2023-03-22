<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm; 

$this->title = 'TIME IN/OUT';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
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
</style>

<div class="site-login">
    <div class="container d-flex justify-content-center align-items-center">
        <!-- <div class="card" >
            <div class="card-body" style="padding:0;"> -->
                <div>
                
                
                <div style="padding:10px;">
                    <div style="margin-bottom:20px;">
                        <div class="d-flex justify-content-center align-items-center">
                            <?php  
                                $imageUrl = Yii::$app->request->baseUrl . '/ref/images/logo_university.png';

                                echo Html::img($imageUrl, ['alt' => 'Example Image','style' => 'filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5));']);
                            ?>
                        </div>
                    </div>
                    
                    <div style="border:1px solid #ddd; padding:10px; padding-top:0px;">

                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6">
                                <?= Html::a('Login',['login'],['style' => 'width:100%;','class' => 'btn btn-outline-light']); ?>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 active-link">
                                <?= Html::a('Time In/Out',['time-in-out'],['style' => 'width:100%; text-decoration:none;', 'class' => 'btn btn-outline-light']); ?>
                            </div>
                        </div>

                        <p style="text-align: center; font-weight:normal; font-size:15px; color:#ae0505; padding:5px; padding-right:50px; padding-left:50px; margin-bottom:0; margin-bottom:20px;">Timesheet Monitoring System for CICT Trainees</p>
                        
                        <div class="card-body">
                            
                            <?php $form = ActiveForm::begin(['id' => 'timein-form']); ?>

                                <?= $form->field($model, 'username2')->textInput(['autofocus' => true, 'placeholder' => 'Username'])->label(false) ?>

                                <?= $form->field($model, 'password2')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

                                <div class="form-group">
                                    <?= Html::submitButton('TIME IN/OUT', ['class' => 'btn btn-warning', 'name' => 'login-button', 'style' => 'width:100%; border-radius:25px;']) ?>
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
