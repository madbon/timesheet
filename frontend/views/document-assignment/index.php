<?php

use common\models\DocumentAssignment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\DocumentAssignmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Task Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task Assignment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'ref_document_type_id',
                'value' => function($model)
                {
                    return $model->documentType->title;
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\DocumentType::find()->all(), 'id', 'title'),
            ],
            'auth_item',
            'type',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, DocumentAssignment $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
