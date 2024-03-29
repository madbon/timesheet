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
</style>

<div>
    <div class="mt-5 offset-lg-3 col-lg-6">
        <div class="d-flex justify-content-center align-items-center">
            <?php  
                $imageUrl = Yii::$app->request->baseUrl . '/ref/images/logo_university.png';

                echo Html::img($imageUrl, ['alt' => 'Example Image','style' => 'filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5));', 'height' => 120, 'width' => 100]);
            ?>
            <h3 class="lead" style="font-size:25px; padding-left:5px; font-weight:500;">CICT Trainees Time In/Out Portal</h3>
        </div>
        <div class="camera" style="margin-bottom: 50px; margin-top:10px;">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <video id="video" width="300" height="224" autoplay></video>
                        </td>
                        <td>
                            <canvas id="canvas" width="300" height="224" style="border:1px solid black;"></canvas>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <button id="snap" class="btn btn-outline-secondary btn-sm" style="width:50%;">CAPTURE PHOTO</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="form-login" style="margin-top:20px;">
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

let faceMatcher = null;

async function loadModels() {
    const modelPath = '/timesheet/backend/web/models';
    // await faceapi.loadTinyFaceDetectorModel(modelPath);
    await faceapi.loadSsdMobilenetv1Model(modelPath);
    await faceapi.loadFaceLandmarkModel(modelPath);
    await faceapi.loadFaceRecognitionModel(modelPath);
}



async function loadReferenceImage(imageUrl) {
    const input = await faceapi.fetchImage(imageUrl);
    const detection = await faceapi
        .detectSingleFace(input)
        .withFaceLandmarks()
        .withFaceDescriptor();

    if (!detection) {
        return;
    }

    const faceDescriptors = [detection.descriptor];
    faceMatcher = new faceapi.FaceMatcher(faceDescriptors);
}



(async function() {

    await loadModels();
    // Replace with the list of stored images paths
    // const storedImages = [
    //     '/timesheet/backend/web/uploads/image1.png',
    //     '/timesheet/backend/web/uploads/image2.png'
    //     // Add more image paths if needed
    // ];

    // Replace with the URL to the reference image
    const referenceImageUrl = '/timesheet/backend/web/uploads/image1.png';
    await loadReferenceImage(referenceImageUrl);

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
        function dataURItoBlob(dataURI) {
            const byteString = atob(dataURI.split(',')[1]);
            const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
            const ab = new ArrayBuffer(byteString.length);
            const ia = new Uint8Array(ab);
            for (let i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], { type: mimeString });
        }

        ctx.drawImage(video, 0, 0, 300, 230);
        capturedImage = canvas.toDataURL('image/png');
        
        const input = await faceapi.bufferToImage(dataURItoBlob(capturedImage));
        const detection = await faceapi
            .detectSingleFace(input, getFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceDescriptor();

        if (!detection) {
            alert('No face detected. Please capture a clear image of your face.');
            capturedImage = null;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            return;
        }
        
        if (!faceMatcher) {
            alert('Please upload a reference image first.');
            return;
        }

        const bestMatch = faceMatcher.findBestMatch(detection.descriptor);
        if (bestMatch.label !== 'unknown') {
            alert('Similar face found: ' + bestMatch.toString());
        } else {
            alert('No similar face found.');
        }
    });



        loginButton.addEventListener('click', function(e) {
            e.preventDefault();

            if (!capturedImage) {
                alert('Please capture an image before recording your time in/out');
                return;
            }

            const formData = new FormData(document.getElementById('login-form'));
            formData.append('imageData', capturedImage);

            fetch('site/login-with-image', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href =  'site/index?user_id=' + data.user_id;
                } else {
                    alert(data.message || 'Time in/out failed');
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

