<?php

namespace frontend\controllers;

use common\models\SubmissionThread;
use common\models\SubmissionThreadSearch;
use common\models\SubmissionReply;
use common\models\SubmissionThreadSeen;
use common\models\SubmissionReplySeen;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\DocumentType;
use yii\helpers\ArrayHelper;
use common\models\AuthAssignment;
use common\models\DocumentAssignment;
use frontend\models\UploadMultipleForm;
use yii\web\UploadedFile;
use common\models\Files;
use yii\helpers\Url;
use common\models\SubmissionArchive;
use common\models\UserData;
use common\models\EvaluationForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use Yii;

/**
 * SubmissionThreadController implements the CRUD actions for SubmissionThread model.
 */
class SubmissionThreadController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all SubmissionThread models.
     *
     * @return string
     */
    public function actionIndex($archive=null)
    {
        $searchModel = new SubmissionThreadSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $documentAss = DocumentAssignment::find()
        ->select(["*",'ref_document_type.title as title','ref_document_type.action_title'])
        ->joinWith('documentType')
        ->where(['auth_item' => Yii::$app->getModule('admin')->getLoggedInUserRoles()])
        ->all();

        $documentSender = DocumentAssignment::find()
        ->select(['ref_document_type.action_title','ref_document_type_id','ref_document_type.required_uploading'])
        ->joinWith('documentType')
        ->where(['auth_item' => Yii::$app->getModule('admin')->getLoggedInUserRoles()])
        ->andWhere(['type' => 'SENDER'])
        ->all();
        // ->createCommand()->rawSql;
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'documentAss' => $documentAss,
            'documentSender' => $documentSender,
            'archive' => $archive,
        ]);
    }

    public function actionDownload($id)
    {
        $file = Files::findOne(['id' => $id]);

        if ($file !== null) {
            $filePath = 'uploads/' . $file->file_hash . '.' . $file->extension;

            if (file_exists($filePath)) {
                return Yii::$app->response->sendFile($filePath, $file->file_name . '.' . $file->extension);
            } else {
                throw new \yii\web\NotFoundHttpException('File not found.');
            }
        } else {
            throw new \yii\web\NotFoundHttpException('File not found.');
        }
    }

    public function actionPreview($id)
    {
        $file = Files::findOne(['id' => $id]);

        if ($file !== null) {
            $filePath = 'uploads/' . $file->file_hash . '.' . $file->extension;

            if (file_exists($filePath)) {
                if (in_array($file->extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                    return Yii::$app->response->sendFile($filePath, $file->file_name . '.' . $file->extension, ['inline' => true]);
                } else if ($file->extension === 'pdf') {
                    return $this->redirect(Url::to('@web/uploads/' . $file->file_hash . '.' . $file->extension));
                } else {
                    throw new \yii\web\BadRequestHttpException('File type not supported for preview.');
                }
            } else {
                throw new \yii\web\NotFoundHttpException('File not found.');
            }
        } else {
            throw new \yii\web\NotFoundHttpException('File not found.');
        }
    }

    public function actionDeleteFile($id)
    {
        $file = Files::findOne(['id' => $id]);

        if ($file !== null) {
            $filePath = 'uploads/' . $file->file_hash . '.' . $file->extension;

            if ($file->delete()) {
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
                Yii::$app->session->setFlash('success', 'File deleted successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Error deleting file. Please try again.');
            }
        } else {
            throw new \yii\web\NotFoundHttpException('File not found.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }



    /**
     * Displays a single SubmissionThread model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->getModule('admin')->documentAssignedAttrib($model->ref_document_type_id,'RECEIVER'))
        {
            if(!SubmissionThreadSeen::find()->where(['user_id' => Yii::$app->user->identity->id, 'submission_thread_id' => $id])->exists())
            {
                date_default_timezone_set('Asia/Manila');
                $modelSubmThreadSeen = new SubmissionThreadSeen();
                $modelSubmThreadSeen->user_id = Yii::$app->user->identity->id;
                $modelSubmThreadSeen->submission_thread_id = $id;
                $modelSubmThreadSeen->date_time = date('Y-m-d H:i:s');
                $modelSubmThreadSeen->save();
            }
        }

        $files = Files::find()->where(['model_id' => $id, 'model_name' => 'SubmissionThread'])->all();

        $replyModel = new SubmissionReply();

        $replyModel->submission_thread_id = $id;
        $replyModel->user_id = Yii::$app->user->identity->id;

         // UPLOAD FILE
         $modelUpload = new UploadMultipleForm();

        if(SubmissionReply::find()->where(['submission_thread_id' => $id])->exists())
        {
            $getLatestReply = SubmissionReply::find()->where(['submission_thread_id' => $id])->all();

            foreach ($getLatestReply as $rep) {
                if(!SubmissionReplySeen::find()->where(['user_id' => Yii::$app->user->identity->id, 'submission_reply_id' => $rep->id])->exists())
                {
                    $modelReplySeen = new SubmissionReplySeen();
                    $modelReplySeen->submission_thread_id = $id;
                    $modelReplySeen->submission_reply_id = $rep->id;
                    $modelReplySeen->user_id = Yii::$app->user->identity->id;
                    $modelReplySeen->date_time = date('Y-m-d H:i:s');
                    $modelReplySeen->save();
                }
            }
            
        }
        

        if ($this->request->isPost) {

            date_default_timezone_set('Asia/Manila');
            $replyModel->date_time = date('Y-m-d H:i:s');

            if ($replyModel->load($this->request->post()) && $modelUpload->load($this->request->post()) && $replyModel->save()) {

                $replyId = $replyModel->id;
                $modelUpload->model_name = "SubmissionReply";
                $modelUpload->model_id = $replyId;
                $modelUpload->imageFiles = UploadedFile::getInstances($modelUpload, 'imageFiles');

                $modelReplySeen = new SubmissionReplySeen();
                $modelReplySeen->submission_reply_id = $replyId;
                $modelReplySeen->user_id = Yii::$app->user->identity->id;
                $modelReplySeen->date_time = date('Y-m-d H:i:s');
                $modelReplySeen->submission_thread_id = $id;
                $modelReplySeen->save();

                if ($modelUpload->uploadMultiple()) {
                    // file is uploaded successfully
                //  \Yii::$app->getSession()->setFlash('success', 'Created successfully');
                //  return $this->redirect(['upload-file', 'id' => $model_id]);
                }
                else
                {
                // print_r($modelUpload->errors); exit;
                }

                Yii::$app->session->setFlash('success', 'Comment/Remarks has been added.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            $replyModel->loadDefaultValues();
        }

        $replyQuery = SubmissionReply::find()->where(['submission_thread_id' => $id])->all();

        return $this->render('view', [
            'model' => $model,
            'files' => $files,
            'replyModel' => $replyModel,
            'replyQuery' => $replyQuery,
            'modelUpload' => $modelUpload,
        ]);
    }

    /**
     * Creates a new SubmissionThread model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($ref_document_type_id=null,$required_uploading=null,$from_eval_form=null,$trainee_user_id = null)
    {
        $model = new SubmissionThread();

        $user_id = Yii::$app->user->identity->id;
        $model->user_id = $user_id;

        $authAssignment = AuthAssignment::find()->where(['user_id' => $user_id])->one();

        $queryDocAss = DocumentAssignment::find()->where(['auth_item' => Yii::$app->getModule('admin')->getLoggedInUserRoles()])->all();

        $docAss = [];
        foreach ($queryDocAss as $key => $row) {
            $docAss[] = $row['ref_document_type_id'];
        }


        $model->ref_document_type_id = $ref_document_type_id;
        $documentType = ArrayHelper::map(DocumentType::find()->where(['id' => $docAss])
        ->andWhere(['id' => $ref_document_type_id]) // ACTIVITY REMINDEr
            ->all(),'id','action_title');

        if(!empty($trainee_user_id))
        {
            $model->tagged_user_id = $trainee_user_id;
        }

        // UPLOAD FILE
        $modelUpload = new UploadMultipleForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $modelUpload->load($this->request->post())) {
                date_default_timezone_set('Asia/Manila');
                $time = time();
                $model->created_at = $time;
                $model->date_time = date('Y-m-d H:i:s');

                if(EvaluationForm::find()->where(['trainee_user_id' => $model->tagged_user_id, 'submission_thread_id' => NULL])->exists())
                {
                    $evalForm = EvaluationForm::find()->where(['trainee_user_id' => $model->tagged_user_id, 'submission_thread_id' => NULL])->all();

                    $model->save();
                    $sub_thread_id = $model->id;

                    foreach ($evalForm as $eval) {
                        $eval->submission_thread_id = $sub_thread_id;
                        $eval->update();
                    }

                    $model_id = $sub_thread_id;

                    // UPLOAD FILE
                    $modelUpload->model_name = "SubmissionThread";
                    $modelUpload->model_id = $model_id;

                    $modelUpload->imageFiles = UploadedFile::getInstances($modelUpload, 'imageFiles');
                    if ($modelUpload->uploadMultiple()) {
                        // file is uploaded successfully
                        \Yii::$app->getSession()->setFlash('success', 'Created successfully');
                        //  return $this->redirect(['upload-file', 'id' => $model_id]);
                    }
                    else
                    {
                        // print_r($modelUpload->errors); exit;
                    }
                    // UPLOADED_FILE_END

                    

                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else
                {
                    return $this->redirect(Yii::$app->request->referrer);
                    $model->loadDefaultValues();
                }
                
            }
        } else {
            $model->loadDefaultValues();
        }

        $userData = UserData::find()->where(['id' => $trainee_user_id])->one();

        return $this->render('create', [
            'model' => $model,
            'documentType' => $documentType,
            'modelUpload' => $modelUpload,
            'documentType' => $documentType,
            'from_eval_form' => $from_eval_form,
            'trainee_user_id' => $trainee_user_id,
            'traineeName' => !empty($userData->userFullNameWithMiddleInitial) ? $userData->userFullNameWithMiddleInitial : "",
            
        ]);
    }

    /**
     * Updates an existing SubmissionThread model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$from_eval_form=null)
    {
        $model = $this->findModel($id);

        $documentType = ArrayHelper::map(DocumentType::find()->all(),'id','title');

        $modelUpload = new UploadMultipleForm();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save() && $modelUpload->load($this->request->post())) {

            // UPLOAD FILE
            $modelUpload->model_name = "SubmissionThread";
            $modelUpload->model_id = $model->id;

            $modelUpload->imageFiles = UploadedFile::getInstances($modelUpload, 'imageFiles');
            if ($modelUpload->uploadMultiple()) {
                // file is uploaded successfully
                \Yii::$app->getSession()->setFlash('success', 'Changed successfully');
            //  return $this->redirect(['upload-file', 'id' => $model_id]);
            }
            else
            {
                print_r($modelUpload->errors); exit;
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'documentType' => $documentType,
            'modelUpload' => $modelUpload,
            'from_eval_form' => $model->ref_document_type_id == 1 ? 'yes' : '',
            'trainee_user_id' => !empty($model->tagged_user_id) ? $model->tagged_user_id : null,
        ]);
    }

    /**
     * Deletes an existing SubmissionThread model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();

        $model = new SubmissionArchive();

        $model->submission_thread_id = $id;
        $model->user_id = Yii::$app->user->identity->id;
        $model->date_time = date('Y-m-d H:i:s');
        $model->save();

        Yii::$app->session->setFlash('success', 'Item has been deleted');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRestore($id)
    {
        $model = SubmissionArchive::find()->where(['submission_thread_id' => $id,'user_id' => Yii::$app->user->identity->id])->one();
        $model->delete();

        Yii::$app->session->setFlash('success', 'Item has been restored');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeletePermanent($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Item has been deleted permanently');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the SubmissionThread model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SubmissionThread the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SubmissionThread::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
