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

            
            <div class="camera">
                <video id="video" width="640" height="480" autoplay></video>
                <button id="snap">Capture</button>
                <canvas id="canvas" width="640" height="480"></canvas>
            </div>
            

            <?php // $form->field($model, 'rememberMe')->checkbox() ?>

            <?php // \Johnson\JayWebcam::widget() ?>

            <?php
                $this->registerJs('
                    $("#loginform-username").val("uname");
                ');
            ?>

            

            <div class="form-group" style="text-align: center;">
                <?= Html::submitButton('TIME IN/OUT: '.'<span style="font-weight:bold;" id="clock"></span>', ['class' => 'btn btn-outline-success btn-block', 'name' => 'login-button', 'style' => 'border-radius:25px;']) ?>
            </div>

        <?php ActiveForm::end(); ?>
        
    </div>
    
</div>

<?php
$this->registerJs(<<<JS
    (function() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const ctx = canvas.getContext('2d');
        const loginButton = document.getElementById('login-button');
        let capturedImage = null;

        navigator.mediaDevices.getUserMedia({ video: true, audio: false })
        .then(function(stream) {
            video.srcObject = stream;
            video.play();
        })
        .catch(function(err) {
            console.log("An error occurred: " + err);
        });

        snap.addEventListener('click', function() {
            ctx.drawImage(video, 0, 0, 640, 480);
            capturedImage = canvas.toDataURL('image/png');
        });

        loginButton.addEventListener('click', function(e) {
            e.preventDefault();

            if (!capturedImage) {
                alert('Please capture an image before logging in');
                return;
            }

            const formData = new FormData(document.getElementById('login-form'));
            formData.append('imageData', capturedImage);

            fetch('/your-api-endpoint', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/your-success-redirect-url';
                } else {
                    alert(data.message || 'Login failed');
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Login failed');
            });
        });
    })();
JS
);
?>
