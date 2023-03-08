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
        <div>
            <!-- <div class="card-body"> -->
                <div class="d-flex justify-content-center align-items-center" style="margin-bottom: 20px;">
                    <?php  
                    $imageUrl = Yii::$app->request->baseUrl . '/ref/images/logo_university.png';

                    echo Html::img($imageUrl, ['alt' => 'Example Image']);
                    ?>
                </div>

               <h5><?= Yii::$app->name ?></h5>

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Username'])->label(false) ?>

                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            <!-- </div> -->
        </div>
    </div>
</div>
