<?php

use common\models\UserTimesheet;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\UserTimesheetSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Timesheet';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-timesheet-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p style="text-align: center;">
        <?= Html::a('TIME IN', ['time-in'], ['class' => 'btn btn-success']) ?>

    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'user_id',
            [
                'attribute' => 'user_id',
                'value' => function($model)
                {
                    return $model->user->fullName;
                }
            ],
            // 'date',
            [
                'attribute' => 'date',
                'value' => function($model)
                {
                    return date('F j, Y', strtotime($model->date));
                }
            ],
            'time_in_am',
            'time_out_am',
            'time_in_pm',
            'time_out_pm',
            
            'remarks',
            [
                'class' => ActionColumn::className(),
                'template' => '{delete}',
                'urlCreator' => function ($action, UserTimesheet $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
