<?php

namespace frontend\controllers;

use common\models\Suffix;
use common\models\SuffixSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SuffixController implements the CRUD actions for Suffix model.
 */
class SuffixController extends Controller
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
     * Lists all Suffix models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SuffixSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Suffix model.
     * @param string $title Title
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($title)
    {
        return $this->render('view', [
            'model' => $this->findModel($title),
        ]);
    }

    /**
     * Creates a new Suffix model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Suffix();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'title' => $model->title]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Suffix model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $title Title
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($title)
    {
        $model = $this->findModel($title);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'title' => $model->title]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Suffix model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $title Title
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($title)
    {
        $this->findModel($title)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Suffix model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $title Title
     * @return Suffix the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($title)
    {
        if (($model = Suffix::findOne(['title' => $title])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
