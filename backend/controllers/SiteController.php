<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\View;
use yii\helpers\Json;
use common\models\UserTimesheet;
use common\models\Files;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['error','capture','login-with-image','backtoportal','get-images'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionGetImages()
    {
        $query = Files::find()->where(['model_name' => 'UserTimesheet'])->all();

        $images = [];
        foreach ($query as $img) {
            $file_path = Yii::getAlias('@backend/web/uploads/') . $img->file_name;
            if(file_exists($file_path))
            {
                $images[] = '/timesheet/backend/web/uploads/'.$img->file_name;
            }
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $images;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($user_id)
    {
        date_default_timezone_set('Asia/Manila');
        $timeSheet = UserTimesheet::findOne(['user_id' => $user_id,'date' => date('Y-m-d')]);
        $timeSheetAll = UserTimesheet::find()->where(['user_id' => $user_id,'date' => date('Y-m-d')])
        ->orderBy(['id' => SORT_ASC])->all();

        return $this->render('index',[
            'user_id' => $user_id,
            'time_in_am' => $timeSheet->time_in_am,
            'time_in_pm' => $timeSheet->time_in_pm,
            'time_out_am' => $timeSheet->time_out_am,
            'time_out_pm' => $timeSheet->time_out_pm,
            'model' => $timeSheet,
            'timeSheetAll' => $timeSheetAll,
        ]);
    }

    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $image = Yii::$app->request->post('image');
        $filename = Yii::getAlias('@backend/web/uploads/') . uniqid() . '.jpg';

        if (file_put_contents($filename, base64_decode($image))) {
            return ['success' => true, 'filename' => $filename];
        } else {
            return ['success' => false];
        }
    }

    public function actionLoginWithImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new LoginForm();
        $model->load(Yii::$app->request->post());

        $imageData = Yii::$app->request->post('imageData');
        $imagePath = null;

        if ($imageData) {
            $imagePath = $this->saveCapturedImage($imageData);
        }

        if ($model->login()) {

            if(!Yii::$app->user->can('time-in-out'))
            {
                Yii::$app->user->logout();
                // Yii::$app->session->setFlash('error', 'Error recording time.');
                return [
                    'success' => false,
                    'message' => 'You have no access to this portal',
                ];
            }

            // TIMESHEET RECORDING_START
            date_default_timezone_set('Asia/Manila');
            $user_id = Yii::$app->user->identity->id;
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $timestamp = strtotime($time);

            $model = UserTimesheet::find()->where(['user_id' => Yii::$app->user->id, 'date' => date('Y-m-d')])->orderBy(['id' => SORT_DESC])->one();
            if (!$model) {
                $model = new UserTimesheet();
                $model->user_id = Yii::$app->user->id;
                $model->date = date('Y-m-d');
                if (date('a', $timestamp) === 'am') {
                    $model->time_in_am = date('H:i:s', $timestamp);
                }
                else
                {
                    $model->time_in_pm = date('H:i:s', $timestamp);
                }
            }
            else
            {
                if (date('a', $timestamp) === 'am') {
                    if($model->time_out_am)
                    {
                        $model = new UserTimesheet();
                        $model->user_id = Yii::$app->user->id;
                        $model->date = date('Y-m-d');
                        $model->time_in_am = date('H:i:s', $timestamp);
                    }else{
                        $model->time_out_am = date('H:i:s', $timestamp);
                    }
                    
                } else { // PM
                    if($model->time_out_am)
                    {
                        if($model->time_out_pm)
                        {
                            $model = new UserTimesheet();
                            $model->user_id = Yii::$app->user->id;
                            $model->date = date('Y-m-d');
                            $model->time_in_pm = date('H:i:s', $timestamp);
                        }
                        else
                        {
                            if($model->time_in_pm)
                            {
                                $model->time_out_pm = date('H:i:s', $timestamp);
                            }   
                            else
                            {
                                $model->time_in_pm = date('H:i:s', $timestamp);
                            }
                        }
                    }
                    else // if empty ung TIME_OUT_AM
                    {
                        if($model->time_out_pm)
                        {
                            $model = new UserTimesheet();
                            $model->user_id = Yii::$app->user->id;
                            $model->date = date('Y-m-d');
                            $model->time_in_pm = date('H:i:s', $timestamp);
                        }
                        else
                        {
                            // if($model->time_in_pm)
                            // {
                            //     $model->time_out_pm = date('H:i:s', $timestamp);
                            // }   
                            // else
                            // {
                                
                            // }
                            $model->time_out_pm = date('H:i:s', $timestamp);
                        }
                    }

                    
                }
            }
            
                
                
            // save the model
            if ($model->save()) {
                // If you need to do something with the image path, you can do it here
                // For example: save the image path to the user's profile
                if ($imagePath) {
                    date_default_timezone_set('Asia/Manila');
                    // Save the captured image data to the table_file
                    $file = new Files();
                    $file->model_name = "UserTimesheet";
                    $file->user_timesheet_time = date('H:i:s', $timestamp);
                    $file->file_name = basename($imagePath);
                    $file->extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                    $file->file_hash = basename($imagePath);
                    $file->user_id = $user_id;
                    $file->model_id = $model->id;
                    $file->created_at = time();
                    $file->save();
                }
            }
            // TIMESHEET RECORDING_END


            return [
                'success' => true,
                'user_id' => $user_id, // Return the user_id
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Invalid username or password.',
            ];
        }
    }


    private function saveCapturedImage($imageData)
    {
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
        $imageName = uniqid() . '.png';
        $imagePath = Yii::getAlias('@backend/web/uploads/') . $imageName;
        file_put_contents($imagePath, $data);
        return $imagePath;
    }

    public function actionCapture()
    {
        $model = new LoginForm();

        $js = <<<JS
            function updateTime() {
                var now = new Date();
                var clock = document.getElementById('clock');
                clock.innerHTML = now.toLocaleTimeString();
            }
            setInterval(updateTime, 1000);
        JS;
        $this->getView()->registerJs($js, View::POS_READY);
        return $this->render('capture',['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionTimein()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        Yii::$app->cache->flush();
        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            date_default_timezone_set('Asia/Manila');
            $user_id = Yii::$app->user->identity->id;
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $timestamp = strtotime($time);
            
            if(!Yii::$app->user->can('time-in-out'))
            {
                
                Yii::$app->user->logout();
                // Yii::$app->session->setFlash('error', 'Error recording time.');
                return $this->goBack();
            }

            $model = UserTimesheet::findOne(['user_id' => Yii::$app->user->id, 'date' => date('Y-m-d')]);
            if (!$model) {
                $model = new UserTimesheet();
                $model->user_id = Yii::$app->user->id;
                $model->date = date('Y-m-d');
                if (date('a', $timestamp) === 'am') {
                    $model->time_in_am = date('H:i:s', $timestamp);
                }
                else
                {
                    $model->time_in_pm = date('H:i:s', $timestamp);
                }
            }
            else
            {
                if (date('a', $timestamp) === 'am') {
                    $model->time_out_am = date('H:i:s', $timestamp);
                } else {
                    if($model->time_out_am)
                    {
                        $model->time_out_am = NULL;
                        $model->time_in_pm = NULL;
                        $model->time_out_pm = date('H:i:s', $timestamp);
                    }
                    else
                    {
                        $model->time_out_am = NULL;
                        $model->time_out_pm = date('H:i:s', $timestamp);
                    }
                }
            }
            
                
                
            // save the model
            if ($model->save()) {
                // Yii::$app->session->setFlash('success', 'Time recorded successfully.');
            } else {
                // Yii::$app->session->setFlash('error', 'Error recording time.');
            }
            
            return $this->redirect(['index','user_id' => $model->user_id]);
            // }
            
            // render the form with an HTML input field for selecting the time
            // return $this->render('index2', ['model' => $model]);
            
            // return $this->goBack();
        }

        $model->password = '';

        $js = <<<JS
            function updateTime() {
                var now = new Date();
                var clock = document.getElementById('clock');
                clock.innerHTML = now.toLocaleTimeString();
            }
            setInterval(updateTime, 1000);
        JS;
        $this->getView()->registerJs($js, View::POS_READY);

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/capture']);
    }

     /**
     * Logout action.
     *
     * @return Response
     */
    public function actionBacktoportal()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/capture']);
    }
}
