<?php

namespace frontend\controllers;

use common\models\Files;
use common\models\ProgramMajor;
use common\models\RefProgram;
use common\models\StudentSection;
use common\models\StudentYear;
use common\models\Suffix;
use common\models\UserData;
use common\models\UserDataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\UploadForm;
use yii\web\UploadedFile;
use common\models\CmsRole;
use common\models\CmsRoleAssignment;
use common\models\AuthAssignment;
use common\models\AuthItem;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use common\components\PdfWidget;
use yii\data\ActiveDataProvider;
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
        return [
            'access' => [
                'class' => AccessControl::class,
                // 'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['user-management-index'],
                    ],
                    [
                        'actions' => ['upload-file'],
                        'allow' => true,
                        'roles' => ['user-management-upload-file'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['user-management-view'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['user-management-update'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['user-management-create'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['user-management-delete'],
                    ],
                    [
                        'actions' => ['delete-role-assigned'],
                        'allow' => true,
                        'roles' => ['user-management-delete-role-assigned'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['user-management-create-trainee','user-management-create-ojt-coordinator','user-management-create-company-supervisor','user-management-create-administrator'],
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
     * Creates a new UserData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($account_type)
    {

        if(!in_array($account_type,['trainee','ojtcoordinator','companysupervisor','administrator']))
        {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        
        $model = new UserData();
        $roleAssignment = new AuthAssignment();

        $queryRole = AuthItem::find()->where(['type' => 1])->all();
        $roleArr = ArrayHelper::map($queryRole, 'name', 'name');

        $suffix = ArrayHelper::map(Suffix::find()->all(), 'title', 'title');
        $student_year = ArrayHelper::map(StudentYear::find()->all(), 'year', 'title');
        $student_section = ArrayHelper::map(StudentSection::find()->all(), 'section', 'section');

        $program = ArrayHelper::map(RefProgram::find()->all(), 'id', 'title');
       
        

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

                $roleAssignment->user_id = (string)$model_id;

                switch ($account_type) {
                    case 'trainee':
                        $roleAssignment->item_name = "Trainee";
                    break;
                    case 'ojtcoordinator':
                        $roleAssignment->item_name = "OjtCoordinator";
                    break;
                    case 'companysupervisor':
                        $roleAssignment->item_name = "CompanySupervisor";
                    break;
                    case 'administrator':
                        $roleAssignment->item_name = "Administrator";
                    break;
                    
                    default:
                        # code...
                    break;
                }
                
                if(!$roleAssignment->save())
                {
                    print_r($roleAssignment->errors); exit;
                }

                return $this->redirect(['upload-file', 'id' => $model_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'roleArr' => $roleArr,
            'suffix' => $suffix,
            'account_type' => $account_type,
            'student_section' => $student_section,
            'student_year' => $student_year,
            'program' => $program,
        ]);
    }

    public function actionDeleteRoleAssigned($user_id)
    {
        if(AuthAssignment::deleteAll(['user_id' => $user_id]))
        {
            \Yii::$app->getSession()->setFlash('success', "This User Account's Role has been removed");
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Lists all UserData models.
     *
     * @return string
     */
    public function actionIndex($account_type = "Trainee")
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
     * Updates an existing UserData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $roleAssignment = new AuthAssignment();

        $queryRole = AuthItem::find()->where(['type' => 1])->all();
        $roleArr = ArrayHelper::map($queryRole, 'name', 'name');

        $suffix = ArrayHelper::map(Suffix::find()->all(), 'title', 'title');
        $student_year = ArrayHelper::map(StudentYear::find()->all(), 'year', 'title');
        $student_section = ArrayHelper::map(StudentSection::find()->all(), 'section', 'section');

        $program = ArrayHelper::map(RefProgram::find()->all(), 'id', 'title');
        $major =  ArrayHelper::map(ProgramMajor::find()->where(['ref_program_id' => $model->ref_program_id])->all(), 'id', 'title');

        

        if ($this->request->isPost && $model->load($this->request->post())) {

            if($model->password)
            {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
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
            'suffix' => $suffix,
            'student_section' => $student_section,
            'student_year' => $student_year,
            'program' => $program,
            'major' => $major,
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
