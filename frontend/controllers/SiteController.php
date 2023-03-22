<?php

namespace frontend\controllers;

use common\models\AuthAssignment;
use common\models\AuthItemChild;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\UserData;
use common\models\UserTimesheet;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\controllers\UserTimesheetController as TimeSheet;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

     /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionTimeInOut()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->timein()) {

            if(Yii::$app->user->can('Trainee'))
            {
                
                if($this->actionRecordTime() == 3)
                {
                    \Yii::$app->getSession()->setFlash('danger', 'Action cannot be performed. Please wait until 1pm. Thank you!');
                    // Yii::$app->user->logout();
                    return $this->redirect('time-in-out');
                    
                }
                else
                {
                    if($this->actionRecordTime() == 1 || $this->actionRecordTime() == 2)
                    {
                        
                        \Yii::$app->getSession()->setFlash('success', 'Your TIME IN/OUT has been recorded');
                        // Yii::$app->user->logout();
                        return $this->redirect('time-in-out');
                        
                    }
                    else
                    {
                        // Yii::$app->user->logout();
                        return $this->redirect('time-in-out');
                    }
                }
            }
            else
            {
                // Yii::$app->user->logout();
                return $this->redirect('time-in-out');
                
            }
           
            // return $this->redirect('time-in-out');
            
        }

        // $model->password = '';

        return $this->render('time_in_out', [
            'model' => $model,
        ]);
    }

    public function actionRecordTime()
    {
        $model = new UserTimesheet();
        date_default_timezone_set('Asia/Manila');
        $user_id = Yii::$app->user->identity->id;
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $model->user_id = $user_id;
        $model->date = $date;

        if(UserTimesheet::find()->where(['user_id' => $user_id, 'date' => $date])->exists())
        { 
            $update = UserTimesheet::find()->where(['user_id' => $user_id, 'date' => $date])
            ->orderBy(['id' => SORT_DESC])->one();
            
            if(time() < strtotime('08:00am'))
            {
                $update->time_out_am = $time;
            }
            else
            {
                if(time() >= strtotime('12:00pm') && time() < strtotime('01:00pm'))
                {
                    if(!empty($update->time_in_pm))
                    {
                        \Yii::$app->getSession()->setFlash('danger', 'Action cannot be performed. Please wait until 1pm. Thank you!');
                        return 3;
                    }
                    
                }

                if (time() >= strtotime('08:00am') && time() <= strtotime('12:00pm')) {
                    if(empty($update->time_out_am))
                    {
                        $update->time_out_am = $time;
                    }
                    else
                    { // save another row in the same date
                        // $model->time_in_am = $time;
                        // $model->save();
                    }
                }
                else
                {
                    if (time() > strtotime('12:00pm') && time() <= strtotime('05:00pm')) {
                        if(empty($update->time_out_am))
                        {
                            if(empty($update->time_in_pm))
                            {
                                if(!empty($update->time_in_am))
                                {
                                    $update->time_out_am = "12:00:00";
                                    $update->time_in_pm = $time;
                                }
                                else
                                { // unnecessary code
                                    $update->time_in_pm = $time;
                                }
                                
                            }
                            else
                            {
                                if(empty($update->time_out_pm))
                                {
                                    $update->time_out_pm = $time;
                                }
                                else
                                { // save another row in the same date
                                    // $model->time_in_pm = $time;
                                    // $model->save();
                                }
                            }
                            
                        }
                        else
                        {
                            if(empty($update->time_in_pm))
                            {
                                $update->time_in_pm = $time;
                            }
                            else
                            {
                                if(empty($update->time_out_pm))
                                {
                                    $update->time_out_pm = $time;
                                }
                                else
                                {// save another row in the same date
                                    // $model->time_in_pm = $time;
                                    // $model->save();
                                }
                            }
                        }
                    } // 12:00pm to 5:00pm -end
                    else
                    { // after 5:00pm
                        if(time() > strtotime('05:00pm'))
                        {
                            if(empty($update->time_out_am))
                            {
                                if(empty($update->time_in_pm))
                                {
                                    $update->time_out_am = "12:00:00";
                                    $update->time_in_pm = "13:00:00";
    
                                    if(empty($update->time_out_pm))
                                    {
                                        $update->time_out_pm = $time;
                                    }
                                }
                                else
                                {
                                    if(empty($update->time_out_pm))
                                    {
                                        $update->time_out_pm = $time;
                                    }
                                    else
                                    { // save another row in the same date
                                        // $model->time_in_pm = $time;
                                        // $model->save();
                                    }
                                }
                            }
                            else
                            {
                                if(empty($update->time_in_pm))
                                {
                                    $update->time_in_pm = $time;
                                }
                                else
                                {
                                    if(empty($update->time_out_pm))
                                    {
                                        $update->time_out_pm = $time;
                                    }
                                    else
                                    { // save another row in the same date
                                        // $model->time_in_pm = $time;
                                        // $model->save();
                                    }
                                }
                            }
                            
                        }
                    }
    
                }
            }

            
            if($update->getOldAttributes() != $update->getAttributes())
            {
                if($update->save())
                {
                    \Yii::$app->getSession()->setFlash('success', 'Your TIME IN/OUT has been recorded');
                    return 2;
                }
                else
                {
                    print_r($update->errors); exit;
                }
            }

        }
        else
        { // NEW DATE TIME IN
            
            if(time() < strtotime('08:00am'))
            {
                $model->time_in_am = $time;
            }
            else
            {
                if (time() >= strtotime('08:00am') && time() <= strtotime('12:00pm')) {
                    $model->time_in_am = $time;
                }
                else
                {
                    if (time() > strtotime('12:00pm') && time() <= strtotime('05:00pm')) {
                        $model->time_in_pm = $time;
                    }
                    else
                    {
                        if(time() > strtotime('05:00pm'))
                        {
                            $model->time_in_pm = $time;
                        }
                    }
                }
            }

            if(!$model->save())
            {
                print_r($model->errors); exit;
            }
            else
            {
                \Yii::$app->getSession()->setFlash('success', 'Your TIME IN/OUT has been recorded');
                return 1;
            }
        }

        
        return 0;
    }

   

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {

            if(Yii::$app->user->can('time-in-out'))
            {
                return $this->redirect('user-timesheet');
            }
            else
            {
                return $this->redirect('user-management');
            }
            
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        // $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
