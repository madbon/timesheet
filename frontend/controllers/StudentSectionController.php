<?php

namespace frontend\controllers;

use common\models\StudentSection;
use common\models\StudentSectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentSectionController implements the CRUD actions for StudentSection model.
 */
class StudentSectionController extends Controller
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
     * Lists all StudentSection models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StudentSectionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentSection model.
     * @param string $section Section
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($section)
    {
        return $this->render('view', [
            'model' => $this->findModel($section),
        ]);
    }

    /**
     * Creates a new StudentSection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new StudentSection();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'section' => $model->section]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StudentSection model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $section Section
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($section)
    {
        $model = $this->findModel($section);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'section' => $model->section]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StudentSection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $section Section
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($section)
    {
        $this->findModel($section)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StudentSection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $section Section
     * @return StudentSection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($section)
    {
        if (($model = StudentSection::findOne(['section' => $section])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
