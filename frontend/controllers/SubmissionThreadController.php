<?php

namespace frontend\controllers;

use common\models\SubmissionThread;
use common\models\SubmissionThreadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\DocumentType;
use yii\helpers\ArrayHelper;
use common\models\AuthAssignment;
use frontend\models\UploadMultipleForm;
use yii\web\UploadedFile;
use common\models\Files;
use yii\helpers\Url;
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
    public function actionIndex()
    {
        $searchModel = new SubmissionThreadSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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



    /**
     * Displays a single SubmissionThread model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $files = Files::find()->where(['model_id' => $id, 'model_name' => 'SubmissionThread'])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'files' => $files,
        ]);
    }

    /**
     * Creates a new SubmissionThread model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SubmissionThread();

        $user_id = \Yii::$app->user->identity->id;
        $model->user_id = $user_id;

        $authAssignment = AuthAssignment::find()->where(['user_id' => $user_id])->one();

        // print_r(DocumentType::find()->where(['auth_item_name' => $authAssignment->item_name, 'type' => 'SENDER'])->createCommand()->rawSql); exit;

        $documentType = ArrayHelper::map(DocumentType::find()->where(['auth_item_name' => $authAssignment->item_name, 'type' => 'SENDER'])->all(),'id','title');

        // UPLOAD FILE
        $modelUpload = new UploadMultipleForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $modelUpload->load($this->request->post())) {
                date_default_timezone_set('Asia/Manila');
                $time = time();
                $model->created_at = $time;
                $model->date_time = date('Y-m-d H:i:s');

                $model->save();

                $model_id = $model->id;

                 // UPLOAD FILE
                 $modelUpload->model_name = "SubmissionThread";
                 $modelUpload->model_id = $model_id;

                 $modelUpload->imageFiles = UploadedFile::getInstances($modelUpload, 'imageFiles');
                 if ($modelUpload->uploadMultiple()) {
                     // file is uploaded successfully
                     \Yii::$app->getSession()->setFlash('success', 'Thread/Activity has been created');
                    //  return $this->redirect(['upload-file', 'id' => $model_id]);
                 }
                 else
                 {
                    print_r($modelUpload->errors); exit;
                 }
                 // UPLOADED_FILE_END

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'documentType' => $documentType,
            'modelUpload' => $modelUpload,
        ]);
    }

    /**
     * Updates an existing SubmissionThread model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $authAssignment = AuthAssignment::find()->where(['user_id' => $model->user_id])->one();

        // print_r(DocumentType::find()->where(['auth_item_name' => $authAssignment->item_name, 'type' => 'SENDER'])->createCommand()->rawSql); exit;

        $documentType = ArrayHelper::map(DocumentType::find()->where(['auth_item_name' => $authAssignment->item_name, 'type' => 'SENDER'])->all(),'id','title');

        $modelUpload = new UploadMultipleForm();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save() && $modelUpload->load($this->request->post())) {

            // UPLOAD FILE
            $modelUpload->model_name = "SubmissionThread";
            $modelUpload->model_id = $model->id;

            $modelUpload->imageFiles = UploadedFile::getInstances($modelUpload, 'imageFiles');
            if ($modelUpload->uploadMultiple()) {
                // file is uploaded successfully
                \Yii::$app->getSession()->setFlash('success', 'Thread/Activity has been changed');
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
