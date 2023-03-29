<?php

use common\models\DocumentType;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\DocumentTypeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Task Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'action_title',
            [
                'label' => 'Required Uploading of Files?',
                'value' => function($model)
                {
                    return $model->required_uploading ? "YES" : "NO";
                }
            ],
            [
                'label' => 'Enabled Tagging?',
                'value' => function($model)
                {
                    return $model->enable_tagging ? "YES" : "NO";
                }
            ],
            [
                'label' => 'Enabled Commenting?',
                'value' => function($model)
                {
                    return $model->enable_commenting ? "YES" : "NO";
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, DocumentType $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
