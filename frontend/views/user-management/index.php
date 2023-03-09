<?php

use common\models\UserData;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\UserDataSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Management';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-data-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' Create User Account', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div style="border:2px solid #ddd; padding:5px;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                'fname',
                'mname',
                'sname',
                'bday',
                'sex',
                'username',
                //'auth_key',
                //'password_hash',
                //'password_reset_token',
                'email:email',
                // 'status',
                //'created_at',
                //'updated_at',
                //'verification_token',
                [
                    'format' => 'raw',
                    'label' => 'Upload',
                    'value' => function($model)
                    {

                        $findFile = Yii::$app->getModule('admin')->FileExistsByQuery('UserData',$model->id);

                        return $findFile ? Html::a((Yii::$app->getModule('admin')->GetIcon('upload-cloud')).' Update Signature',['upload-file','id' => $model->id,'message' => 'Update Signature'],['class' => 'btn btn-sm btn-outline-primary']) : Html::a((Yii::$app->getModule('admin')->GetIcon('upload-cloud')).' Upload Signature',['upload-file','id' => $model->id],['class' => 'btn btn-sm btn-outline-secondary']);
                    }
                ],
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, UserData $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>
    </div>

</div>

<?php
$this->registerJs('
    $("table").removeClass("table-bordered").addClass("table-hover");
');
?>
