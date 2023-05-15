<?php

namespace frontend\controllers;

use common\models\EvaluationForm;
use common\models\EvaluationFormSearch;
use common\models\EvaluationCriteria;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * EvaluationFormController implements the CRUD actions for EvaluationForm model.
 */
class EvaluationFormController extends Controller
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
     * Lists all EvaluationForm models.
     *
     * @return string
     */
    public function actionIndex($trainee_user_id)
    {
        

        if(!EvaluationForm::find()->where(['trainee_user_id' => $trainee_user_id])->exists())
        {
            $criteria = EvaluationCriteria::find()->all();
            foreach ($criteria as $crit) {
                $modelEvalForm = new EvaluationForm();
                $modelEvalForm->trainee_user_id = $trainee_user_id;
                $modelEvalForm->user_id = Yii::$app->user->identity->id;
                $modelEvalForm->evaluation_criteria_id = $crit->id;
                $modelEvalForm->save(false);
            }
        }
        

        $searchModel = new EvaluationFormSearch();
        $searchModel->trainee_user_id = $trainee_user_id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        $model = EvaluationForm::find()->where(['trainee_user_id' => $trainee_user_id])->one();

        $traineeName = $model->traineeUser->userFullNameWithMiddleInitial;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'traineeName' => $traineeName,
            'trainee_user_id' => $trainee_user_id,
        ]);
    }

    /**
     * Displays a single EvaluationForm model.
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
     * Creates a new EvaluationForm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new EvaluationForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EvaluationForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success','Score has been saved!');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EvaluationForm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the EvaluationForm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return EvaluationForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EvaluationForm::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
