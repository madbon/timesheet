<?php

namespace frontend\controllers;

use common\models\UserTimesheet;
use common\models\UserTimesheetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * UserTimesheetController implements the CRUD actions for UserTimesheet model.
 */
class UserTimesheetController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                // 'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['index','create','update','view','delete','time-in'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserTimesheet models.
     *
     * @return string
     */
    public function actionIndex()
    {
        date_default_timezone_set('Asia/Manila');
        $searchModel = new UserTimesheetSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        $user_id = Yii::$app->user->identity->id;
        $date = date('Y-m-d');

        $time = date('H:i:s');
        $timeInOut = "";

        $model = UserTimesheet::findOne(['user_id' => $user_id]);
        

        // $query = UserTimesheet::find()->where(['user_id' => $user_id, 'date' => $date])->one();

        // if (time() >= strtotime('08:00am') && time() <= strtotime('12:00pm')) {
        //     if(UserTimesheet::find()->where(['user_id' => $user_id, 'date' => $date])->exists())
        //     {
        //         if(empty($query->time_out_am))
        //         {
        //             $timeInOut = "TIME OUT";
        //         }
        //         else
        //         {
        //             $timeInOut = "TIME IN";
        //         }
        //     }
        //     else
        //     {
        //         $timeInOut = "TIME IN";
        //     }
        // }
        // else
        // {
        //     if (time() >= strtotime('12:00pm') && time() <= strtotime('05:00pm')) {
        //         if(UserTimesheet::find()->where(['user_id' => $user_id, 'date' => $date])->exists())
        //         {
        //             if(empty($query->time_out_pm))
        //             {
        //                 $timeInOut = "TIME OUT";
        //             }
        //             else
        //             {
        //                 $timeInOut = "COMPLETED";
        //             }
        //         }
        //         else
        //         {
        //             $timeInOut = "TIME IN";
        //         }
        //     }
        //     else
        //     {
        //         if(time() > strtotime('05:00pm'))
        //         {
        //             if(UserTimesheet::find()->where(['user_id' => $user_id, 'date' => $date])->exists())
        //             {
        //                 if(empty($query->time_out_pm))
        //                 {
        //                     $timeInOut = "TIME OUT";
        //                 }
        //                 else
        //                 {
        //                     $timeInOut = "COMPLETED";
        //                 }
        //             }
        //             else
        //             {
        //                 $timeInOut = "TIME IN";
        //             }
        //         }
        //     }
        // }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'timeInOut' => $timeInOut,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single UserTimesheet model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserTimesheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserTimesheet();

        $model->user_id = Yii::$app->user->identity->id;

        if ($this->request->isPost) {

            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionTimeIn()
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
                        return $this->redirect(['index']);
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
                    \Yii::$app->getSession()->setFlash('success', 'Your TIME has been recorded');
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
                \Yii::$app->getSession()->setFlash('success', 'Your TIME has been recorded');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Updates an existing UserTimesheet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            \Yii::$app->getSession()->setFlash('success', 'Remarks has been saved');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserTimesheet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserTimesheet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserTimesheet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserTimesheet::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}