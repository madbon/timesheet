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
                        'actions' => ['timein', 'error'],
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($user_id)
    {
        date_default_timezone_set('Asia/Manila');
        $timeSheet = UserTimesheet::findOne(['user_id' => $user_id,'date' => date('Y-m-d')]);

        return $this->render('index',[
            'user_id' => $user_id,
            'time_in_am' => $timeSheet->time_in_am,
            'time_in_pm' => $timeSheet->time_in_pm,
            'time_out_am' => $timeSheet->time_out_am,
            'time_out_pm' => $timeSheet->time_out_pm,
            'model' => $timeSheet,
        ]);
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

        return $this->goHome();
    }
}
