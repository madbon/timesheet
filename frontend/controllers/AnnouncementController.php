<?php

namespace frontend\controllers;

use common\models\Announcement;
use common\models\AnnouncementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AnnouncementProgramTags;
use frontend\models\UploadMultipleInAnnouncement;
use yii\web\UploadedFile;
use common\models\Files;
use yii\helpers\Url;
use Yii;

/**
 * AnnouncementController implements the CRUD actions for Announcement model.
 */
class AnnouncementController extends Controller
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
     * Lists all Announcement models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AnnouncementSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = new Announcement();

        $model->user_id = Yii::$app->user->identity->id;

        $modelUpload = new UploadMultipleInAnnouncement();

        if ($this->request->isPost) {
            date_default_timezone_set('Asia/Manila');
            $model->date_time = date('Y-m-d H:i:s');

            if ($model->load($this->request->post()) &&  $model->save() && $modelUpload->load($this->request->post())) {

                $model_id = $model->id;
                // UPLOAD FILE
                $modelUpload->model_name = "Announcement";
                $modelUpload->model_id = $model_id;

                $modelUpload->imageFiles = UploadedFile::getInstances($modelUpload, 'imageFiles');
                $modelUpload->uploadMultiple();

                if($model->selected_programs)
                {
                    $model_id = $model->id;
                    $selected_programs = $model->selected_programs;
                    
                    foreach ($selected_programs as $key => $value) {
                        $tags = new AnnouncementProgramTags();
                        $tags->announcement_id = $model_id;
                        $tags->ref_program_id = $value;
                        $tags->save();
                    }
                }
                
               

                \Yii::$app->getSession()->setFlash('success', 'Announcement has been posted successfully');
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'modelUpload' => $modelUpload,
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
     * Displays a single Announcement model.
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
     * Creates a new Announcement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Announcement();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                \Yii::$app->getSession()->setFlash('warning', 'Announcement has been posted successfully');
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Announcement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->announcementProgramTags)
        {
            $arrTags = [];
            foreach ($model->announcementProgramTags as $tags) {
                $arrTags[] = $tags->ref_program_id;
            }

            $model->selected_programs = $arrTags;
        }

        $modelUpload = new UploadMultipleInAnnouncement();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save() && $modelUpload->load($this->request->post())) {

            if($model->selected_programs)
            {
                $model_id = $id;
                $selected_programs = $model->selected_programs;

                $modelDelete = AnnouncementProgramTags::find()->where(['announcement_id' => $id])->all();
                    
                foreach ($modelDelete as $ann) {
                    $ann->delete();
                }
                
                foreach ($selected_programs as $key => $value) {
                    $tags = new AnnouncementProgramTags();
                    $tags->announcement_id = $model_id;
                    $tags->ref_program_id = $value;
                    $tags->save();
                }

                $model_id = $id;
                // UPLOAD FILE
                
            }

            $modelUpload->model_name = "Announcement";
            $modelUpload->model_id = $id;

            $modelUpload->imageFiles = UploadedFile::getInstances($modelUpload, 'imageFiles');
            $modelUpload->uploadMultiple();

            \Yii::$app->getSession()->setFlash('success', 'Announcement has been updated');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $content = $this->renderAjax('update', [
            'model' => $model,
            'modelUpload' => $modelUpload,
        ]);

        return $content;

        // return $this->render('update', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Deletes an existing Announcement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        \Yii::$app->getSession()->setFlash('success', 'Announcement has been deleted');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Announcement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Announcement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Announcement::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
