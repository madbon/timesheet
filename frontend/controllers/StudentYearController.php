<?php

namespace frontend\controllers;

use common\models\StudentYear;
use common\models\StudentYearSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentYearController implements the CRUD actions for StudentYear model.
 */
class StudentYearController extends Controller
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
     * Lists all StudentYear models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StudentYearSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentYear model.
     * @param int $year Year
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($year)
    {
        return $this->render('view', [
            'model' => $this->findModel($year),
        ]);
    }

    /**
     * Creates a new StudentYear model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new StudentYear();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'year' => $model->year]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StudentYear model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $year Year
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($year)
    {
        $model = $this->findModel($year);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'year' => $model->year]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StudentYear model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $year Year
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($year)
    {
        $this->findModel($year)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StudentYear model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $year Year
     * @return StudentYear the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($year)
    {
        if (($model = StudentYear::findOne(['year' => $year])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
