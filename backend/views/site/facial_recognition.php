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
.mirrored {
    transform: scaleX(-1);
}
</style>

<center>
<div>
    <div class="container" style="margin-top:20px;">
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
                            <video id="video" width="600" height="550"  autoplay></video>
                        </td>
                        <td style="display:none;">
                            <!-- <canvas id="canvas" width="300" height="224" style="border:1px solid black;"></canvas> -->
                            <canvas id="canvas" width="600" height="450" style="border:1px solid black;" ></canvas>
                        </td>
                    </tr>
                    <tr style="display: none;">
                        <td colspan="2" style="text-align: center;">
                            <button id="snap" class="btn btn-outline-secondary btn-lg" style="width:50%;"><i class="fas fa-camera"></i> CAPTURE PHOTO</button>
                        </td>
                    </tr>
                    <tr style="display:none;" id="different-timein">
                        <td colspan="2" style="text-align: center;">
                            <p style="padding-top:50px;">
                                <?= Html::a('<i class="fas fa-sign-in-alt"></i> Use Login Credentials to record time in/out',['/capture-login-no-facial-recog'],['class' => 'btn btn-primary btn-lg']); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="form-login" style="display:none;">
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
</center>
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
        let closestMatch = { distance: Infinity, imagePath: null };

        for (const storedImageUrl of storedImages) {
            const storedDescriptor = await getFaceDescriptor(storedImageUrl);
            if (storedDescriptor) {
                const distance = faceapi.euclideanDistance(capturedDescriptor, storedDescriptor);
                if (distance < closestMatch.distance) {
                    closestMatch.distance = distance;
                    closestMatch.imagePath = storedImageUrl;
                }
            }
        }
        return closestMatch;
    }


    async function fetchStoredImages() {
        const response = await fetch('site/get-images');
        const storedImages = await response.json();
        return storedImages;
    }

    async function processVideoFrame() {
        

        if (!video.paused && !video.ended) {

            const ctx = canvas.getContext('2d');
            

            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const currentFrame = canvas.toDataURL('image/png');
            const currentDescriptor = await getFaceDescriptor(currentFrame);

            if (currentDescriptor) {
                console.log('face detected');
                const response = await fetch('site/get-images');
                const storedImages = await response.json();
                const threshold = 0.30;
                const closestMatch = await isFaceSimilar(currentDescriptor, storedImages);
                const distance = closestMatch.distance;
                const matchedFilename = closestMatch.imagePath.split('/').pop();

                if (distance < threshold) {
                    // Save the captured photo
                    capturedPhoto = currentFrame;

                    // Do something when a similar face is found, e.g., display a message
                    console.log('Similar face found! Distance:', distance.toFixed(4), matchedFilename);

                    // Optional: stop the video stream and facial recognition processing
                    // video.pause();
                } else {
                    // Do something when no similar face is found, e.g., clear the captured photo
                    // console.log('No Face Found..');
                                    
                // console.log('processvideoframe');
            // console.log('processvideoframe');
                    capturedPhoto = null;
                }
            }
            else
            {
                console.log('no face detected..');
            }

        }
        // Schedule the next frame processing
        requestAnimationFrame(processVideoFrame);
    }





    (async function() {
        // Replace with the list of stored images paths

        const storedImages = await fetchStoredImages();

        console.log(storedImages);

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

        var countFailedFaceRecog = 0;
        var contentDifferentTimeIn = document.getElementById("different-timein");
        let capturedPhoto = null;

        let streaming = false;


        navigator.mediaDevices
        .getUserMedia({
            video: {
                width: { ideal: 600 },
                height: { ideal: 450 },
                facingMode: 'user',
            },
        })
        .then(function(stream) {
            video.srcObject = stream;
            video.onloadedmetadata = async function(e) {
                try {
                    await video.play();
                } catch (error) {
                    console.error('Error starting video playback:', error);
                }
            };
        })
        .catch(function(err) {
            console.error(err);
        });

        

    video.addEventListener('canplay', function() {
        if (!streaming) {
            canvas.setAttribute('width', video.videoWidth);
            canvas.setAttribute('height', video.videoHeight);
            streaming = true;
        }
    }, false);

    // Mirror the video
    // video.style.transform = 'scaleX(-1)';
    // ctx.translate(canvas.width, 0);
    // ctx.scale(-1, 1);

    video.addEventListener('play', function() {
        //  setInterval(async function() {
        //     if (video.paused || video.ended) return;
        //     ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
             processVideoFrame();
        //  }, 3000);
    });


    })();
JS
);
?>

