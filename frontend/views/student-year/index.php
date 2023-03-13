<?php

use common\models\StudentYear;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\StudentYearSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Student Years';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-year-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Student Year', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'year',
            'title',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, StudentYear $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'year' => $model->year]);
                 }
            ],
        ],
    ]); ?>


</div>
