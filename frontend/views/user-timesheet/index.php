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
            // [
            //     'attribute' => 'user_id',
            //     'value' => function($model)
            //     {
            //         return $model->user->fullName;
            //     }
            // ],
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
                    $time1_am = strtotime($model->time_in_am);
                    $time2_am = strtotime($model->time_out_am);
                    $time1_pm = strtotime($model->time_in_pm);
                    $time2_pm = strtotime($model->time_out_pm);

                    // compute AM time difference
                    $diffSecondsAM = $time2_am - $time1_am;
                    $diffHoursAM = floor($diffSecondsAM / 3600);
                    $diffMinutesAM = floor(($diffSecondsAM % 3600) / 60);
                    $diffSecondsAM = $diffSecondsAM % 60;

                    // compute PM time difference
                    $diffSecondsPM = $time2_pm - $time1_pm;
                    $diffHoursPM = floor($diffSecondsPM / 3600);
                    $diffMinutesPM = floor(($diffSecondsPM % 3600) / 60);
                    $diffSecondsPM = $diffSecondsPM % 60;

                    // compute total time difference
                    $totalSeconds = $diffSecondsAM + $diffSecondsPM;
                    $totalMinutes = $diffMinutesAM + $diffMinutesPM + floor($totalSeconds / 60);
                    $totalHours = $diffHoursAM + $diffHoursPM + floor($totalMinutes / 60);
                    $totalMinutes = $totalMinutes % 60;
                    $totalSeconds = $totalSeconds % 60;

                    
                    // compute overtime
                    if ($totalHours > 8) {
                        $overtimeHours = $totalHours - 8;
                        $returnVal = $overtimeHours . 'hrs ' . $totalMinutes . 'mins ' . $totalSeconds . ' secs';
                    } else {
                        $returnVal = '';
                    }

                    return $returnVal;

                }
            ],
            'remarks',
            [
                'label' => 'Total No. of Hours',
                'value' => function($model)
                {
                    $time1_am = strtotime($model->time_in_am);
                    $time2_am = strtotime($model->time_out_am);
                    $time1_pm = strtotime($model->time_in_pm);
                    $time2_pm = strtotime($model->time_out_pm);

                    // compute AM time difference
                    $diffSecondsAM = $time2_am - $time1_am;
                    $diffHoursAM = floor($diffSecondsAM / 3600);
                    $diffMinutesAM = floor(($diffSecondsAM % 3600) / 60);
                    $diffSecondsAM = $diffSecondsAM % 60;

                    // compute PM time difference
                    $diffSecondsPM = $time2_pm - $time1_pm;
                    $diffHoursPM = floor($diffSecondsPM / 3600);
                    $diffMinutesPM = floor(($diffSecondsPM % 3600) / 60);
                    $diffSecondsPM = $diffSecondsPM % 60;

                    // compute total time difference
                    $totalSeconds = $diffSecondsAM + $diffSecondsPM;
                    $totalMinutes = $diffMinutesAM + $diffMinutesPM + floor($totalSeconds / 60);
                    $totalHours = $diffHoursAM + $diffHoursPM + floor($totalMinutes / 60);
                    $totalMinutes = $totalMinutes % 60;
                    $totalSeconds = $totalSeconds % 60;

                    // display result
                    return $totalHours . ' hours, ' . $totalMinutes . ' minutes, ' . $totalSeconds . ' seconds';

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
