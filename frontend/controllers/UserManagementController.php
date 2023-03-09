<?php

namespace frontend\controllers;

use common\models\Files;
use common\models\UserData;
use common\models\UserDataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\UploadForm;
use yii\web\UploadedFile;
use common\models\CmsRole;
use common\models\CmsRoleAssignment;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * UserManagementController implements the CRUD actions for UserData model.
 */
class UserManagementController extends Controller
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
     * Lists all UserData models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserDataSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     /**
     * Displays a single UserData model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUploadFile($id,$message="Upload Signature")
    {
        $modelUpload = new UploadForm();

        if (Yii::$app->request->isPost) {

            $modelUpload->model_name = basename(get_class($this->findModel($id)));
            $modelUpload->model_id = $id;

            $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');
            if ($modelUpload->upload()) {
                // file is uploaded successfully
                \Yii::$app->getSession()->setFlash('success', 'File has been uploaded');
                return $this->redirect(['upload-file', 'id' => $id, 'message' => $message]);
            }
        }

        return $this->render('_upload_file', [
            'model' => $this->findModel($id),
            'modelUpload' => $modelUpload,
            'message' => $message,
        ]);
    }

    /**
     * Displays a single UserData model.
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
     * Creates a new UserData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserData();
        $roleAssignment = new CmsRoleAssignment();

        $queryRole = CmsRole::find()->all();
        $roleArr = ArrayHelper::map($queryRole, 'id', 'title');

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key = Yii::$app->security->generateRandomString();
                $model->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
                

                if($model->save())
                {
                    \Yii::$app->getSession()->setFlash('success', 'Data has been saved');
                }

                // ROLE ASSIGNMENT SAVING
                $model_id = $model->id;

                $roleAssignment->user_id = $model_id;
                $roleAssignment->cms_role_id = $model->role_id;
                $roleAssignment->save();

                return $this->redirect(['upload-file', 'id' => $model_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'roleArr' => $roleArr,
        ]);
    }

    /**
     * Updates an existing UserData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $roleAssignment = new CmsRoleAssignment();

        $queryRole = CmsRole::find()->all();
        $roleArr = ArrayHelper::map($queryRole, 'id', 'title');
        

        $queryRoleAssignment = CmsRoleAssignment::find()->where(['user_id' => $id])->one();
        $model->role_id = !empty($queryRoleAssignment->cms_role_id) ? $queryRoleAssignment->cms_role_id : NULL;
        

        if ($this->request->isPost && $model->load($this->request->post())) {

            if($model->password)
            {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            }

            // print_r($model->role_id); exit;

            // ROLE ASSIGNMENT SAVING
            if(CmsRoleAssignment::find()->where(['user_id' => $id])->exists())
            {
                // Yii::$app->db->createCommand()
                // ->update(CmsRoleAssignment::tableName(), ['user_id' => $id], 'cms_role_id = :cms_role_id', [':cms_role_id' => $model->role_id])
                // ->execute();

                $modelUpdate = CmsRoleAssignment::find()->where(['user_id' => $id])->one();
                $modelUpdate->cms_role_id = $model->role_id;
                $modelUpdate->save();
            }
            else
            {
                // ROLE ASSIGNMENT SAVING
                $model_id = $model->id;

                $roleAssignment->user_id = $model_id;
                $roleAssignment->cms_role_id = $model->role_id;
                $roleAssignment->save();
            }

            if($model->save())
            {
                \Yii::$app->getSession()->setFlash('success', 'Changes has been saved');
            }

            

            return $this->redirect(['view', 'id' => $model->id]);
        }

        

        return $this->render('update', [
            'model' => $model,
            'roleArr' => $roleArr,
        ]);
    }

    /**
     * Deletes an existing UserData model.
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
     * Finds the UserData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserData::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
