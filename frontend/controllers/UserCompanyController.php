<?php

namespace frontend\controllers;

use common\models\Company;
use common\models\UserData;
use common\models\UserCompany;
use common\models\UserCompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use Yii;

/**
 * UserCompanyController implements the CRUD actions for UserCompany model.
 */
class UserCompanyController extends Controller
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
     * Lists all UserCompany models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserCompanySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // public function actionCompanyJson()
    // {
    //     $data = Company::find()->select(['name', 'longitude', 'latitude', 'address','contact_info'])->asArray()->all();

    //     // Encode the data to JSON format
    //     $json = Json::encode($data);

    //     // Set the content type header to JSON
    //     // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    //     // Return the JSON data
    //     return $json;
    // }

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
     * Displays a single UserCompany model.
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
     * Creates a new UserCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($user_id)
    {
        $model = new UserCompany();
        $model->user_id = $user_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $googleMap = $this->renderFile(Yii::getAlias('@app/web/googlemap/index.html'));

        return $this->render('create', [
            'model' => $model,
            'googleMap' => $googleMap,
        ]);
    }

    public function actionGoogleMap()
    {
        $content = $this->renderFile(Yii::getAlias('@app/web/googlemap/index_trainee.html'));
        // $content = file_get_contents('C:\xampp7\htdocs\timesheet\googlemap\index.html');
        return $this->render('google-map', [
            'content' => $content,
        ]);
    }

    public function actionMapData($search=null)
    {

        $query = UserData::find()
            ->select([
                'ref_company.latitude',
                'ref_company.longitude',
                'ref_company.id',
                'ref_company.address',
                'ref_company.name',
                'ref_company.contact_info',
                'COUNT(user.id) as count_students'
            ])
            ->joinWith('userCompany.company')
            ->joinWith('authAssignment')
            ->where(['NOT', ['user.id' => null]])
            ->andWhere(['user.status' => 10])
            ->andWhere(['auth_assignment.item_name' => 'Trainee'])
            ->andFilterWhere(['user.ref_program_id' => Yii::$app->getModule('admin')->GetAssignedProgram()])
            ->groupBy(['ref_company.id']);

        if ($search !== null) {
            $query->andWhere(['like', 'ref_company.name', $search]);
        }

        $data = $query->asArray()->all();

        $json = Json::encode($data);

        return $json;
    }


    /**
     * Updates an existing UserCompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserCompany model.
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
     * Finds the UserCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserCompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserCompany::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
