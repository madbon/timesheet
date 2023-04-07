<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\LoginForm */

?>

<style>
.help-block
{
    color:red;
}
table.table tbody tr td
{
    padding:0;
}
</style>

<div>
    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            <?php  
                $imageUrl = Yii::$app->request->baseUrl . '/ref/images/logo_university.png';

                echo Html::img($imageUrl, ['alt' => 'Example Image','style' => 'filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5));', 'height' => 120, 'width' => 100]);
            ?>
            <h3 class="lead" style="font-size:25px; padding-left:5px; font-weight:500;">CICT Trainees Time In/Out Portal</h3>
        </div>
        <div class="camera" style="margin-bottom: 50px; margin-top:10px; padding:0; margin:0;">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <!-- <video id="video" width="300" height="224" autoplay></video> -->
                            <video id="video" width="600" height="550" autoplay></video>
                        </td>
                        <td>
                            <!-- <canvas id="canvas" width="300" height="224" style="border:1px solid black;"></canvas> -->
                            <canvas id="canvas" width="600" height="450" style="border:1px solid black;"></canvas>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <button id="snap" class="btn btn-outline-secondary btn-sm" style="width:50%;">CAPTURE PHOTO</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="form-login">
                                <?php $form = ActiveForm::begin([
                                    'id' => 'login-form',
                                ]); ?>
                                

                                    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Username, student ID, or email']) ?>

                                    <?= $form->field($model, 'password')->textInput() ?>

                                    <?php
                                        $js = new JsExpression("
                                            $('#loginform-password').on('keyup', function() {
                                                $(this).attr('type', 'password');
                                            });
                                        ");
                                        
                                        // Register the JavaScript code
                                        $this->registerJs($js);
                                    ?>

                                    <?php // $form->field($model, 'rememberMe')->checkbox() ?>

                                    <div class="form-group" style="margin-top: 10px; text-align:center;">
                                        <?= Html::submitButton('TIME IN/OUT: '.'<span style="font-weight:bold;" id="clock"></span>', ['class' => 'btn btn-outline-danger', 'name' => 'login-button', 'id' => 'login-button', 'style' => 'width:100%; border-radius:25px;']) ?>
                                    </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$this->registerJs(<<<JS
    async function loadModels() {
        const modelPath = '/timesheet/backend/web/models';
        await faceapi.loadTinyFaceDetectorModel(modelPath);
        await faceapi.loadFaceLandmarkModel(modelPath);
        await faceapi.loadFaceRecognitionModel(modelPath);
    }



    loadModels();

    async function getFaceDescriptor(imageUrl) {
        const input = await faceapi.fetchImage(imageUrl);
        const detection = await faceapi.detectSingleFace(input, new faceapi.TinyFaceDetectorOptions());
        if (!detection) {
            return null;
        }

        const landmarks = await faceapi.detectFaceLandmarks(input);
        const descriptor = await faceapi.computeFaceDescriptor(input, landmarks);
        return descriptor;
    }

    async function isFaceSimilar(capturedDescriptor, storedImages) {
        let minDistance = Infinity;
        
        for (const storedImageUrl of storedImages) {
            const storedDescriptor = await getFaceDescriptor(storedImageUrl);
            if (storedDescriptor) {
            const distance = faceapi.euclideanDistance(capturedDescriptor, storedDescriptor);
            if (distance < minDistance) {
                minDistance = distance;
            }
            }
        }

        return minDistance;
    }

    (async function() {
        // Replace with the list of stored images paths
        const storedImages = [
            '/timesheet/backend/web/uploads/1.png',
            '/timesheet/backend/web/uploads/2.png',
            '/timesheet/backend/web/uploads/3.png',
            '/timesheet/backend/web/uploads/4.png',
            '/timesheet/backend/web/uploads/5.png',
            '/timesheet/backend/web/uploads/6.png',
            '/timesheet/backend/web/uploads/7.png',
            '/timesheet/backend/web/uploads/8.png',
            '/timesheet/backend/web/uploads/9.png',
            '/timesheet/backend/web/uploads/10.png',
            '/timesheet/backend/web/uploads/11.png',
            '/timesheet/backend/web/uploads/12.png',
            '/timesheet/backend/web/uploads/13.png',
            '/timesheet/backend/web/uploads/14.png',
            '/timesheet/backend/web/uploads/15.png',
            '/timesheet/backend/web/uploads/16.png',
            '/timesheet/backend/web/uploads/17.png',
            '/timesheet/backend/web/uploads/18.png',
            '/timesheet/backend/web/uploads/19.png',
            '/timesheet/backend/web/uploads/20.png',
            // Add more image paths if needed
        ];

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const ctx = canvas.getContext('2d');
        const loginButton = document.getElementById('login-button');
        let capturedImage = null;
        let capturedDescriptor = null;

        navigator.mediaDevices.getUserMedia({ video: true, audio: false })
        .then(function(stream) {
            video.srcObject = stream;
            video.play();
        })
        .catch(function(err) {
            console.log("An error occurred: " + err);
        });

        snap.addEventListener('click', async function() {
            ctx.drawImage(video, 0, 0, 600, 450);
            capturedImage = canvas.toDataURL('image/png');
            capturedDescriptor = await getFaceDescriptor(capturedImage);

            // const bestMatch = faceMatcher.findBestMatch(detection.descriptor);

            if (!capturedDescriptor) {
                alert('No face detected. Please capture a clear image of your face.');
                capturedImage = null;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            } else {
                // const threshold = 0.30; // Change this value to a lower number if needed
                // const distance = await isFaceSimilar(capturedDescriptor, storedImages);
                
                // if (distance < threshold) {
                // alert('Similar face found! Distance: ' + distance.toFixed(4));
                // } else {
                // alert('No similar face found. Distance: ' + distance.toFixed(4) + '. Please try again.');
                // capturedImage = null;
                // ctx.clearRect(0, 0, canvas.width, canvas.height);
                // }
            }
        });


        loginButton.addEventListener('click', function(e) {
            e.preventDefault();

            if (!capturedImage) {
                alert('Please capture an image before recording your time in/out');
                return;
            }

            const userId = '2'; // Replace 'someUserId' with the actual user ID you want to send
            const formData = new FormData(document.getElementById('login-form'));
            formData.append('imageData', capturedImage);
            formData.append('user_id', userId); // Add user ID to the POST request

            fetch('site/register-image', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Image saved successfully');
                } else {
                    alert(data.message || 'Failed to save image');
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Failed to save image');
            });
        });


    })();
JS
);
?>

