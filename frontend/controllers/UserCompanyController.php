<?php

namespace frontend\controllers;

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
        $content = $this->renderFile(Yii::getAlias('@app/web/googlemap/index.html'));
        // $content = file_get_contents('C:\xampp7\htdocs\timesheet\googlemap\index.html');
        return $this->render('google-map', [
            'content' => $content,
        ]);
    }

    public function actionMapData()
    {
        $data = UserCompany::find()->select(['name', 'longitude', 'latitude', 'address','contact_info'])->asArray()->all();

        // Encode the data to JSON format
        $json = Json::encode($data);

        // Set the content type header to JSON
        // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Return the JSON data
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
