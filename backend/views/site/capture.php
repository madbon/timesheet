<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\LoginForm */

?>

<div class="row">
    <div class="col-sm-6">
        <div class="camera" style="margin-top: 50px;">
            <div class="row">
                <div class="col-sm-6">
                    <video id="video" width="300" height="300" autoplay></video>
                </div>
                <div class="col-sm-6" style="vertical-align:middle">
                    <canvas id="canvas" width="300" height="230" style="border:1px solid black;"></canvas>
                </div>
            </div>
            <button id="snap" class="btn btn-secondary">Capture</button>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="site-login">
            <h1>Time In/Out</h1>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
            ]); ?>
            

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?php // $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Time In/Out', ['class' => 'btn btn-primary', 'name' => 'login-button', 'id' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
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
            ctx.drawImage(video, 0, 0, 300, 230);
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

            fetch('login-with-image', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'site/index?user_id='+data.user_id;
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
