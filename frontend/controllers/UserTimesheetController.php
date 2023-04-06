<?php

namespace frontend\controllers;

use common\models\UserTimesheet;
use common\models\UserTimesheetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use common\models\Files;
use yii\helpers\Url;
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
                        'actions' => ['index','create','update','view','delete','time-in','preview-pdf','record','record-time','preview-photo','preview-captured-photo'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update-timeout'],
                        'allow' => true,
                        'roles' => ['edit-time'],
                    ],
                    [
                        'actions' => ['validate-timesheet'],
                        'allow' => true,
                        'roles' => ['validate-timesheet'],
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

    public function actionPreviewPhoto($model_id,$time)
    {
        $query = UserTimesheet::findOne(['id' => $model_id]);

        $formatted_time = !empty($time) ? date('g:i:s A', strtotime($time)) : "";
        return $this->renderAjax('preview_photo',[
            'model_id' => $model_id,
            'time' => $time,
            'formatted_time' => $formatted_time,
            'date' => !empty($query->date) ? $query->date : null,
        ]);
    }

    public function actionPreviewCapturedPhoto($model_id,$time)
    {
        $file = Files::find()
        ->where(['model_id' => $model_id,'user_timesheet_time' => $time,'model_name' => 'UserTimesheet'])
        ->one();

        if ($file !== null) {
            $filePath = Url::to('@backend/web/uploads/' . $file->file_hash);

            if (file_exists($filePath)) {
                return Yii::$app->response->sendFile($filePath, $file->file_name, ['inline' => true]);
            } else {
                throw new \yii\web\NotFoundHttpException('File not found.');
            }
        } else {
            throw new \yii\web\NotFoundHttpException('File not found.');
        }
    }

    public function actionValidateTimesheet($id)
    {
        $query = UserTimesheet::findOne(['id' => $id]);
        

        if($query->status)
        {
            $query->status = 0;
            \Yii::$app->getSession()->setFlash('warning', 'The Status is back to pending');
            $query->save();
        }
        else
        {
            \Yii::$app->getSession()->setFlash('success', 'The selected record has been validated');
            $query->status = 1;
            $query->save();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPreviewPdf($user_id,$month= null,$month_id=null,$year=null)
    {
        if(!Yii::$app->user->can('view-other-timesheet'))
        {
            if(Yii::$app->user->identity->id != $user_id)
            {
                throw new NotFoundHttpException("Page not found");
            }
        }
        
        $model = UserTimesheet::findOne(['user_id' => $user_id]);

        $month = $month ? $month : date('F', strtotime('M'));
        $month_id = $month_id ? $month_id : date('m');
        $year = $year ? $year : date('Y');

        $content = $this->renderPartial('_reportView2',[
            'model' => $model,
            'month' => $month,
            'month_id' => $month_id,
            'year' => $year,
            'user_id' => $user_id,
        ]);
    
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_LETTER, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            'marginLeft' => 5,
            'marginRight' => 5,
            'marginTop' => 10,
            'marginBottom' => 1,
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '

                .page-break {
                    page-break-before: always;
                }

                table.table thead tr th
                {
                    font-size:11px;
                    text-align: center;
                    border:1px solid black;
                    border-bottom:none;
                } 
                
                table.table thead tr:nth-child(2) th
                {
                    background: #fbbc04;
                    border-bottom:none;
                } 
                
                table.table tbody tr td
                {
                    font-size:11px;
                    padding:0;
                    padding-left: 2px;
                    padding-right:2px;
                    text-align: center;
                    vertical-align: middle;
                    border:1px solid black;
                }
            
                table.table tbody tr td a
                {
                    font-size:11px;
                }
            
                table.table
                {
                    background: white;
                }
            
                table.table tbody tr td:first-child
                {
                    font-weight: bold;
                }
                table.table tbody tr td:last-child
                {
                    text-align: center;
                    padding:0;
                }
            
                table.table-primary-details tbody tr td
                {
                    padding: 0;  
                    text-transform: uppercase;
                }

                table.summary-details
                {
                    background: white;
                    border:none;
                }
                table.summary-details tbody tr td
                {
                    border:1px solid black;
                    padding:5px;
                    background:#ffe28b;
                    
                }

                table.summary-details tbody tr td:nth-child(1)
                {
                    font-weight:bold;
                }
            ', 
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [ 
                // 'SetHeader'=>['Krajee Report Header'], 
                // 'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    /**
     * Lists all UserTimesheet models.
     *
     * @return string
     */
    public function actionIndex($trainee_user_id = null,$month= null,$month_id=null,$year=null)
    {
        date_default_timezone_set('Asia/Manila');
        // $searchModel = new UserTimesheetSearch();
        // $dataProvider = $searchModel->search($this->request->queryParams);
        $month = $month ? $month : date('F', strtotime('M'));
        $month_id = $month_id ? $month_id : date('m');
        $year = $year ? $year : date('Y');
        
        $date = date('Y-m-d');

        $time = date('H:i:s');
        $timeInOut = "";

        $user_id = Yii::$app->user->can('Trainee') ? Yii::$app->user->identity->id : $trainee_user_id;

        $model = UserTimesheet::findOne(['user_id' => $user_id]);
        
        $queryMonth = UserTimesheet::find()
        ->select([new \yii\db\Expression('YEAR(date) as year'), new \yii\db\Expression('DATE_FORMAT(date, "%M") as month'),new \yii\db\Expression('MONTH(date) as month_id')])
        ->where(['user_id' => $user_id])
        ->andWhere(['YEAR(date)' => $year])
        ->groupBy(['month'])
        ->orderBy(['MONTH(date)' => SORT_ASC])
        ->all();

        $queryYear = UserTimesheet::find()
        ->select([new \yii\db\Expression('YEAR(date) as year')])
        ->where(['user_id' => $user_id])
        ->groupBy(['year'])
        ->all();

        return $this->render('index2', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
            'timeInOut' => $timeInOut,
            'model' => $model,
            'queryMonth' => $queryMonth,
            'queryYear' => $queryYear,
            'month' => $month,
            'month_id' => $month_id,
            'year' => $year,
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

    // public function actionRecordTime()
    // {
    //     date_default_timezone_set('Asia/Manila');
    //     $user_id = Yii::$app->user->identity->id;
    //     $date = date('Y-m-d');
    //     $time = date('H:i:s');
    //     $timestamp = strtotime($time);
    // }

    public function actionRecord()
    {
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
                Yii::$app->session->setFlash('success', 'Time recorded successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Error recording time.');
            }
            
            return $this->redirect(['index']);
        // }
        
        // render the form with an HTML input field for selecting the time
        return $this->render('index2', ['model' => $model]);
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
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

     /**
     * Updates an existing UserTimesheet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateTimeout($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            \Yii::$app->getSession()->setFlash('success', 'Time Out has been saved');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('update_time_out', [
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