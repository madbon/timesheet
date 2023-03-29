<?php

namespace frontend\controllers;

use common\models\DocumentAssignment;
use common\models\DocumentAssignmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AuthAssignment;
use common\models\AuthItem;
use yii\helpers\ArrayHelper;
use common\models\DocumentType;
/**
 * DocumentAssignmentController implements the CRUD actions for DocumentAssignment model.
 */
class DocumentAssignmentController extends Controller
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
     * Lists all DocumentAssignment models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DocumentAssignmentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocumentAssignment model.
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
     * Creates a new DocumentAssignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DocumentAssignment();

        $auth_item = AuthItem::find()->where(['type' => 1])->all();
        $qryDocumentType = DocumentType::find()->all();

        $authItem = ArrayHelper::map($auth_item,'name','name');
        $documentType = ArrayHelper::map($qryDocumentType,'id','title');

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'authItem' => $authItem,
            'documentType' => $documentType,
        ]);
    }

    /**
     * Updates an existing DocumentAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $auth_item = AuthItem::find()->where(['type' => 1])->all();
        $qryDocumentType = DocumentType::find()->all();

        $authItem = ArrayHelper::map($auth_item,'name','name');
        $documentType = ArrayHelper::map($qryDocumentType,'id','title');

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'authItem' => $authItem,
            'documentType' => $documentType,
        ]);
    }

    /**
     * Deletes an existing DocumentAssignment model.
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
     * Finds the DocumentAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DocumentAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DocumentAssignment::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
