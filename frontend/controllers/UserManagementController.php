<?php

namespace frontend\controllers;

use common\models\Files;
use common\models\UserCompany;
use common\models\Company;
use common\models\ProgramMajor;
use common\models\Department;
use common\models\Position;
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
use frontend\models\UploadExcel;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\web\View;
use yii\helpers\Url;
use PhpOffice\PhpSpreadsheet\IOFactory;
use common\models\UserImport;
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
                    [
                        'actions' => ['register-face'],
                        'allow' => true,
                        'roles' => ['user-management-register-face'],
                    ],
                    [
                        'actions' => ['company-json','update-my-account','upload-my-signature','register-image','preview-captured-photo','delete-face-photo','import-trainees','save-imported-trainees','download-template'],
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

    public function actionDownloadTemplate()
    {
        $fileName = 'trainees_import_template.xlsx';
        $filePath = Yii::getAlias('@frontend/web/excel_template/') . $fileName;

        if (file_exists($filePath)) {
            // Set headers for download
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');

            // Send the file
            readfile($filePath);
        } else {
            throw new \yii\web\NotFoundHttpException("The template file does not exist.");
        }
        
        exit;
    }

    public function actionImportTrainees($program_id = null)
    {
        $model = new UploadExcel();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload()) {
                $inputFileName = 'uploads/' . $model->file->name;
                $spreadsheet = IOFactory::load($inputFileName);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                // Assuming the first row contains the headers

                // echo "<pre>";
                
                array_shift($rows);
                
                // print_r($rows); exit;

                Yii::$app->session['imported_trainees'] = $rows;
                // Yii::$app->session['program_course'] = $program_id;

                return $this->render('import_result', ['rows' => $rows,'program_id' => $program_id]);
            }
        }

        return $this->render('import_trainees', ['model' => $model,'program_id' => $program_id]);
    }

    public function actionSaveImportedTrainees($program_id)
    {
        $rows = Yii::$app->session['imported_trainees'];
        $program = Yii::$app->session['program_course'];

        foreach ($rows as $row) {
            $student = new UserImport();
            $student->student_idno = $row[0];
            $student->fname = $row[1];
            $student->mname = $row[2];
            $student->sname = $row[3];
            $student->suffix = $row[4];
            $student->bday = $row[5];
            $student->sex = $row[6];
            $student->mobile_no = $row[7];
            $student->address = $row[8];
            $student->ref_program_id =$program_id;
            $student->ref_program_major_id = Yii::$app->getModule('admin')->getMajorCode($row[9],$program_id);
            $student->student_year = $row[10];
            $student->student_section = $row[11];
            $student->email = $row[12];
            
            // $student->ref_program_id = $row[12];

            $student->username = $row[0];
            $student->password_hash = Yii::$app->security->generatePasswordHash($row[0]);

            if($student->save())
            {
                $student_id = $student->id;
                $authAssignment = new AuthAssignment();
                $authAssignment->item_name = 'Trainee';
                $authAssignment->user_id = $student_id;
                $authAssignment->save(false);
            }
        }

    //     $student = new UserImport();
    //     $student->student_idno = $row[0];
    //     $student->fname = $row[1];
    //     $student->mname = $row[2];
    //     $student->sname = $row[3];
    //     $student->bday = $row
    // // getMajorCode($major_abbrev,$program_id)

        Yii::$app->session->setFlash('success', 'Imported Successfully');
        return $this->redirect(['index']);
    }

    public function actionDeleteFacePhoto($id)
    {
        $file = Files::findOne(['id' => $id]);

        if ($file !== null) {
            $filePath = 'uploads/' . $file->file_hash . '.' . $file->extension;

            if ($file->delete()) {
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
                Yii::$app->session->setFlash('success', 'Image deleted successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Error deleting file. Please try again.');
            }
        } else {
            throw new \yii\web\NotFoundHttpException('File not found.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPreviewCapturedPhoto($id)
    {
        $file = Files::find()
        ->where(['id' => $id])
        ->one();
        // ->createCommand()->rawSql;


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

    public function actionRegisterImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;

        // Get the user ID from POST data
        $userId = $request->post('user_id');

        $imageData = Yii::$app->request->post('imageData');
        $imagePath = null;

        if ($imageData) {
            $imagePath = $this->saveCapturedImage($imageData);

        }

        

        if ($imagePath) {
            date_default_timezone_set('Asia/Manila');
            // Save the captured image data to the table_file
            $file = new Files();
            $file->model_name = "UserFacialRegister";
            $file->file_name = basename($imagePath);
            $file->extension = pathinfo($imagePath, PATHINFO_EXTENSION);
            $file->file_hash = basename($imagePath);
            $file->user_id = $userId;
            $file->model_id = $userId;
            $file->created_at = time();
            $file->save(false);

            // if($file->save())
            // {
                return [
                    'success' => true,
                    'user_id' => $userId, // Return the user_id
                    // 'error' => $file->errors
                ];
                
            // }
            // else
            // {
            //     return [
            //         'success' => false,
            //         'message' => $userId,
            //     ];
            // }

            
        }
        else
        {
            return [
                'success' => false,
                'message' => 'Something wrong',
            ];
        }
        
    }

    public function actionRegisterFace($user_id)
    {
        $model = new UserData();

        $userModel = UserData::find()->where(['id' => $user_id])->one();

        $fileModel = Files::find()->where(['model_id' => $user_id, 'model_name' => 'UserFacialRegister'])->all();

        return $this->render('register_face',['model' => $model, 'user_id' => $user_id, 'userModel' => $userModel,'fileModel' => $fileModel,]);
    }

    private function saveCapturedImage($imageData)
    {
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
        $imageName = uniqid() . '.png';
        $imagePath = Yii::getAlias('@backend/web/uploads/') . $imageName;
        file_put_contents($imagePath, $data);
        return $imagePath;
    }

    public function actionCompanyJson($q = null)
    {
        $query = Company::find()->select(['id','name', 'longitude', 'latitude', 'address', 'contact_info'])
        ->orderBy(['name' => SORT_ASC]);

        if (!is_null($q)) {
            $query->andFilterWhere(['like', 'name', $q]);
        }

        $data = $query->asArray()->all();

        // Encode the data to JSON format
        $json = Json::encode($data);

        // Set the content type header to JSON
        // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Return the JSON data
        return $json;
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
        $userCompany = new UserCompany();

        $queryRole = AuthItem::find()->where(['type' => 1])->all();
        $roleArr = ArrayHelper::map($queryRole, 'name', 'name');

        $suffix = ArrayHelper::map(Suffix::find()->all(), 'title', 'title');
        $student_year = ArrayHelper::map(StudentYear::find()->all(), 'year', 'title');
        $student_section = ArrayHelper::map(StudentSection::find()->all(), 'section', 'section');

        $program = ArrayHelper::map(RefProgram::find()->all(), 'id', 'title');

        $position = ArrayHelper::map(Position::find()->all(), 'id', 'position');
        $department = ArrayHelper::map(Department::find()->all(), 'id', 'title');

        $company = ArrayHelper::map(Company::find()->select(['id','CONCAT(name," (", address, ")") as name'])->all(), 'id', 'name');
       
        $itemName = NULL;


        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($this->request->isPost) {
            
            if ($model->load($this->request->post())) {


                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key = Yii::$app->security->generateRandomString();
                $model->verification_token = Yii::$app->security->generateRandomString() . '_' . time();

                if($model->save())
                {
                    \Yii::$app->getSession()->setFlash('success', 'Data has been saved');
                }
                else
                {
                    // print_r($model->errors); exit;
                }
                

                // ROLE ASSIGNMENT SAVING
                $model_id = $model->id;

                $roleAssignment->user_id = (string)$model_id;

                switch ($account_type) {
                    case 'trainee':
                        $roleAssignment->item_name = "Trainee";
                        $itemName = "Trainee";
                    break;
                    case 'ojtcoordinator':
                        $roleAssignment->item_name = "OjtCoordinator";
                        $itemName = "OjtCoordinator";
                    break;
                    case 'companysupervisor':
                        $roleAssignment->item_name = "CompanySupervisor";
                        $itemName = "CompanySupervisor";
                    break;
                    case 'administrator':
                        $roleAssignment->item_name = "Administrator";
                        $itemName = "Administrator";
                    break;
                    
                    default:
                        # code...
                    break;
                }
                
                if(!$roleAssignment->save())
                {
                    // print_r($roleAssignment->errors); exit;
                }

                $userCompany->user_id = $model_id;
                $userCompany->ref_company_id = $model->company;

                if(!$userCompany->save())
                {
                    // print_r($userCompany->errors); exit;
                }

                return $this->redirect(['index', 
                    'UserDataSearch[item_name]' => $itemName,
                    'UserDataSearch[fname]' => $model->fname, 
                    'UserDataSearch[sname]' => $model->sname, 
                ]);
                
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
            'position' => $position,
            'department' => $department,
            'company' => $company,
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
                \Yii::$app->getSession()->setFlash('success', 'e-Signature has been uploaded');
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
    public function actionUploadMySignature($id,$message="Upload Signature")
    {
        if(Yii::$app->user->identity->id != $id)
        {
            throw new NotFoundHttpException("Page not found");
        }


        $modelUpload = new UploadForm();

        if (Yii::$app->request->isPost) {

            $modelUpload->model_name = basename(get_class($this->findModel($id)));
            $modelUpload->model_id = $id;

            $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');
            if ($modelUpload->upload()) {
                // file is uploaded successfully
                \Yii::$app->getSession()->setFlash('success', 'e-Signature has been uploaded');
                return $this->redirect(['upload-my-signature', 'id' => $id, 'message' => $message]);
            }
        }

        return $this->render('_upload_my_signature', [
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
        

        if(ProgramMajor::find()->where(['ref_program_id' => $model->ref_program_id])->exists())
        {
            $major =  ArrayHelper::map(ProgramMajor::find()->where(['ref_program_id' => $model->ref_program_id])->all(), 'id', 'title');
        }
        else
        {
            $major =  ['not_applicable' => '-- NOT APPLICABLE --'];
            $model->ref_program_major_id = 'not_applicable';
        }

        $position = ArrayHelper::map(Position::find()->all(), 'id', 'position');
        $department = ArrayHelper::map(Department::find()->all(), 'id', 'title');

        $model->company = !empty($model->userCompany->ref_company_id) ? $model->userCompany->ref_company_id : NULL;

        $company = ArrayHelper::map(Company::find()->select(['id','CONCAT(name," (", address, ")") as name'])->all(), 'id', 'name');

        $model->item_name = !empty($model->authAssignment->item_name) ? $model->authAssignment->item_name : null;

        $old_role = $model->item_name;

        if ($this->request->isPost && $model->load($this->request->post())) {

            if($model->password)
            {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            }

            if($old_role == $model->item_name)
            {
                if($model->save())
                {
                    \Yii::$app->getSession()->setFlash('success', 'Changes has been saved');
                }
                else
                {
                    \Yii::$app->getSession()->setFlash('danger', "A Supervisor has already been assigned to this department. You cannot assign this user to this department.");
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            }
            else
            {
                if($old_role == 'OjtCoordinator')
                {
                    foreach ($model->coordinatorPrograms as $coor) {
                        $coor->delete();
                    }
                }
                // print_r($model->item_name); exit;
                $model->authAssignment->item_name = $model->item_name;
                $model->authAssignment->save();

                


                 \Yii::$app->getSession()->setFlash('warning', 'Role has been changed successfully. Please fill out other required fields below.');
                return $this->redirect(['update', 'id' => $model->id]);
            }
           

            if(UserCompany::find()->where(['user_id' => $model->id])->exists())
            {
                $userCompany = UserCompany::find()->where(['user_id' => $model->id])->one();
                $userCompany->ref_company_id = $model->company;
            
                if(!$userCompany->save())
                {
                    // print_r($userCompany->errors); exit;
                }
            }
            else
            {
                $newUserCompany = new UserCompany();
                $newUserCompany->user_id = $model->id;
                $newUserCompany->ref_company_id = $model->company;
                $newUserCompany->save();
            }
            

           

            $authAssigned = AuthAssignment::find()->where(['user_id' => $model->id])->one();
            $authAssigned->item_name = $model->item_name;
            $authAssigned->save();


            return $this->redirect(['index', 
            'UserDataSearch[item_name]' => $model->item_name,
            'UserDataSearch[fname]' => $model->fname,
            'UserDataSearch[sname]' => $model->sname,
        ]);
        }

        

        return $this->render('update', [
            'model' => $model,
            'roleArr' => $roleArr,
            'suffix' => $suffix,
            'student_section' => $student_section,
            'student_year' => $student_year,
            'program' => $program,
            'major' => $major,
            'position' => $position,
            'department' => $department,
            'company' => $company,
        ]);
    }

    /**
     * Updates an existing UserData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateMyAccount($id)
    {
        if(Yii::$app->user->identity->id != $id)
        {
            throw new NotFoundHttpException("Page not found");
        }

        $model = $this->findModel($id);
        $roleAssignment = new AuthAssignment();

        $queryRole = AuthItem::find()->where(['type' => 1])->all();
        $roleArr = ArrayHelper::map($queryRole, 'name', 'name');

        $suffix = ArrayHelper::map(Suffix::find()->all(), 'title', 'title');
        $student_year = ArrayHelper::map(StudentYear::find()->all(), 'year', 'title');
        $student_section = ArrayHelper::map(StudentSection::find()->all(), 'section', 'section');

        $program = ArrayHelper::map(RefProgram::find()->all(), 'id', 'title');
        $major =  ArrayHelper::map(ProgramMajor::find()->where(['ref_program_id' => $model->ref_program_id])->all(), 'id', 'title');

        $position = ArrayHelper::map(Position::find()->all(), 'id', 'position');
        $department = ArrayHelper::map(Department::find()->all(), 'id', 'title');

        $model->company = !empty($model->userCompany->ref_company_id) ? $model->userCompany->ref_company_id : NULL;

        $company = ArrayHelper::map(Company::find()->select(['id','CONCAT(name," (", address, ")") as name'])->all(), 'id', 'name');

        $model->item_name = !empty($model->authAssignment->item_name) ? $model->authAssignment->item_name : null;

       

        if ($this->request->isPost && $model->load($this->request->post())) {

            if($model->password)
            {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            }

            if($model->save())
            {
                \Yii::$app->getSession()->setFlash('success', 'Changes has been saved');
            }

            // print_r($model->company); exit;

            if(UserCompany::find()->where(['user_id' => $model->id])->exists())
            {
                $userCompany = UserCompany::find()->where(['user_id' => $model->id])->one();
                $userCompany->ref_company_id = $model->company;
            
                if(!$userCompany->save())
                {
                    print_r($userCompany->errors); exit;
                }
            }
            else
            {
                $newUserCompany = new UserCompany();
                $newUserCompany->user_id = $model->id;
                $newUserCompany->ref_company_id = $model->company;
                $newUserCompany->save();
            }
            

           

            $authAssigned = AuthAssignment::find()->where(['user_id' => $model->id])->one();
            $authAssigned->item_name = $model->item_name;
            $authAssigned->save();


            return $this->redirect(['update-my-account', 
            'id' => $id,
        ]);
        }

        

        return $this->render('update-my-account', [
            'model' => $model,
            'roleArr' => $roleArr,
            'suffix' => $suffix,
            'student_section' => $student_section,
            'student_year' => $student_year,
            'program' => $program,
            'major' => $major,
            'position' => $position,
            'department' => $department,
            'company' => $company,
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
