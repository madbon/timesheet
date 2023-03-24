<?php

use common\models\RefProgram;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\RefProgramSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Programs/Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-program-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Program/Course', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'abbreviation',
            'required_hours',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, RefProgram $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
