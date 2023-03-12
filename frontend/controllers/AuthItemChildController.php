<?php

namespace frontend\controllers;

use common\models\AuthItem;
use common\models\AuthItemChild;
use common\models\AuthItemChildSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * AuthItemChildController implements the CRUD actions for AuthItemChild model.
 */
class AuthItemChildController extends Controller
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

    public function actionGetAvailablePermissions($name)
    {
        $assignedPermissions = AuthItemChild::find()
        ->where(['parent' => $name])
        ->all();

        $arrAssPerms = [];
        foreach ($assignedPermissions as $key => $assPerm) {
            $arrAssPerms[] = $assPerm['child'];
        }

        $permissions = AuthItem::find()
        ->where(['type' => 2])
        ->andWhere(['NOT',['name' => $arrAssPerms]])
        ->all();

        
        if($permissions)
        {
            $options = '<option> -- SELECT PERMISSION -- </option>';
            foreach ($permissions as $permission) {
                $options .= "<option value='{$permission->name}'>{$permission->name}</option>";
            }
        }
        else
        {
            $options = '<option>You have assigned all permissions to this role</option>';
        }

        return $options;
    }

    /**
     * Lists all AuthItemChild models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemChildSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItemChild model.
     * @param string $parent Parent
     * @param string $child Child
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($parent, $child)
    {
        return $this->render('view', [
            'model' => $this->findModel($parent, $child),
        ]);
    }

    /**
     * Creates a new AuthItemChild model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AuthItemChild();
        $roles = AuthItem::find()->all();
        $permissions = AuthItem::find()->where(['type' => 2])->all();

        $roleArr = ArrayHelper::map($roles, 'name', 'name');
        $permissionsArr = ArrayHelper::map($permissions, 'name', 'name');

        if ($this->request->isPost) {
           
            
            if ($model->load($this->request->post()) && $model->save()) {
                \Yii::$app->getSession()->setFlash('success', "Data has been saved");
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'roleArr' => $roleArr,
            'permissionsArr' => $permissionsArr,
        ]);
    }

    /**
     * Updates an existing AuthItemChild model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $parent Parent
     * @param string $child Child
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($parent, $child)
    {
        $model = $this->findModel($parent, $child);

        $roles = AuthItem::find()->all();
        // $permissions = AuthItem::find()->where(['type' => 2])->all();

        $roleArr = ArrayHelper::map($roles, 'name', 'name');
       

        // 
        $assignedPermissions = AuthItemChild::find()
        ->where(['parent' => $parent])
        ->all();

        $arrAssPerms = [];
        foreach ($assignedPermissions as $key => $assPerm) {
            $arrAssPerms[] = $assPerm['child'];
        }

        $permissions = AuthItem::find()
        ->where(['type' => 2])
        ->andWhere(['NOT',['name' => $arrAssPerms]])

        ->all();
        // 

        $permissionsArr = ArrayHelper::map($permissions, 'name', 'name');

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'parent' => $model->parent, 'child' => $model->child]);
        }

        return $this->render('update', [
            'model' => $model,
            'roleArr' => $roleArr,
            'permissionsArr' => $permissionsArr,
            'child' => $child,
        ]);
    }

    /**
     * Deletes an existing AuthItemChild model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $parent Parent
     * @param string $child Child
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($parent, $child)
    {
        $this->findModel($parent, $child)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItemChild model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $parent Parent
     * @param string $child Child
     * @return AuthItemChild the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($parent, $child)
    {
        if (($model = AuthItemChild::findOne(['parent' => $parent, 'child' => $child])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
