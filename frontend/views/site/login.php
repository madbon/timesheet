<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm; 

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
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

                    <p style="text-align: center; font-weight:normal; font-size:15px; color:#ae0505; padding:5px; padding-right:50px; padding-left:50px; margin-bottom:0; border:1px solid #ddd; border-bottom:none;">Timesheet Monitoring System for CICT Trainees</p>
                    <div style="border:1px solid #ddd; padding:20px; padding-top:20px;">
                        
                        <div class="card-body">
                            
                            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Username'])->label(false) ?>

                                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

                                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                                <div class="form-group">
                                    <?= Html::submitButton('Login', ['class' => 'btn btn-danger', 'name' => 'login-button', 'style' => 'width:100%; border-radius:25px;']) ?>
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
