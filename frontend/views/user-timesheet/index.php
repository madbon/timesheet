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
            [
                'label' => 'Overtime',
                'value' => function($model)
                {
                    return "PENDING FEATURE";
                }
            ],
            'remarks',
            [
                'label' => 'Total No. of Hours',
                'value' => function($model)
                {
                    // $time1 = strtotime($model->time_in_pm);
                    // $time2 = strtotime($model->time_out_pm);
                    // $diffSeconds = $time2 - $time1;
                    // $diffHours = floor($diffSeconds / 3600);
                    // $diffMinutes = floor(($diffSeconds % 3600) / 60);
                    // $diffSeconds = $diffSeconds % 60;

                    // return $diffHours . ' hours ' . $diffMinutes . ' minutes ' . $diffSeconds . ' seconds';
                    return "PENDING FEATURE";
                }
            ],
            
            [
                'class' => ActionColumn::className(),
                'template' => '{update}',
                'urlCreator' => function ($action, UserTimesheet $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
