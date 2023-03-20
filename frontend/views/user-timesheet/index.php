<?php

use common\models\UserTimesheet;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\FormatConverter;

/** @var yii\web\View $this */
/** @var common\models\UserTimesheetSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Timesheet';
$this->params['breadcrumbs'][] = $this->title;
date_default_timezone_set('Asia/Manila');
?>
<style>
    table.table thead tr th
    {
        font-size:11px;
        text-align: center;
        border:1px solid black;
    } 
    
    table.table thead tr:nth-child(2) th
    {
        background: #fbbc04;
    } 
    
    table.table tbody tr td
    {
        font-size:11px;
        padding: 2px;
        text-align: center;
        vertical-align: middle;
        border:1px solid black;
    }

    table.table tbody tr td a
    {
        font-size:11px;
    }

    table.table
    {
        background: white;
    }

    table.table tbody tr td:first-child
    {
        font-weight: bold;
    }
    table.table tbody tr td:last-child
    {
        text-align: center;
        padding:5px;
    }

    table.table-primary-details tbody tr td
    {
        padding: 5px;  
        text-transform: uppercase;
    }

</style>

<div class="user-timesheet-index">

    

    <h1 style="text-align: center; font-size:30px; font-weight:bold;">DAILY TIME RECORD</h1>

    <p style="text-align: center;">
        <?= Html::a("RECORD TIME IN/OUT", ['time-in'], ['class' => 'btn btn-outline-dark']) ?>

    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="container">
        <table class="table-primary-details">
            <tbody>
                <tr>
                    <td style="font-weight:bold;">NAME:</td>
                    <td colspan="3" style="border-bottom:2px solid black; font-weight:bold; text-transform:uppercase;"><?= $model->user->userFullName; ?></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">MONTH:</td>
                    <td colspan="3" style="border-bottom:2px solid black; font-weight:bold;"><?= date('F', strtotime('M')) ?></td>
                </tr>
                <tr>
                    <td>OFFICE HOUR:</td>
                    <td style="color:red;">IN: 8:00AM <br/>OUT: 12:00PM</td>
                    <td style="color:red;" colspan="2">IN: 1:00PM <br/>OUT: 05:00PM</td>
                </tr>
            </tbody>
        </table>
        
        <?php
            // Define the date range
            
            $current_year = date('Y');
            $current_month = date('m');

            $start_date = new DateTime("$current_year-$current_month-01");
            $end_date = new DateTime("$current_year-$current_month-01");
            $end_date->modify('last day of this month');

            $interval = new DateInterval('P1D');
            $date_range = new DatePeriod($start_date, $interval, $end_date->modify('+1 day')); // Add one day to include end date

            // Display the data in an HTML table
            echo "<table class='table table-bordered'>";
            echo "<thead>";
            echo "<tr>
                    <th></th>
                    <th colspan='2'>AM</th>
                    <th colspan='2'>PM</th>
                    <th colspan='5'></th>
            </tr>";
            echo "<tr>
                    <th>DAYS</th>
                    <th>IN</th>
                    <th>OUT</th>
                    <th>IN</th>
                    <th>OUT</th>
                    <th>OVERTIME</th>
                    <th>TOTAL NO. OF HOURS</th>
                    <th>REMARKS</th>
                    <th>STATUS</th>
                    <th></th>
            </tr>";
            echo "</thead>";
            echo "<tbody>";

            $totalHoursRendered = 0;
            $totalMinutesRendered = 0;
            $totalSecondsRendered = 0;

            foreach ($date_range as $date) {
                $models = UserTimesheet::findAll(['date' => $date->format('Y-m-d')]); // Retrieve all models for date

                

                if ($models) {

                    foreach ($models as $model) {

                    // TOTAL NO. OF HOURS 

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
                    if ($time1_pm < strtotime('01:00:00 PM')) {
                        // adjust for time before 12:00 PM
                        $diffSecondsPM =  $time2_pm - strtotime('01:00:00 PM');
                        // $diffSecondsPM += strtotime('01:00:00 PM') - $time1_pm;
                    } else {
                        // adjust for time after 12:00 PM
                        $diffSecondsPM = $time2_pm - $time1_pm;
                    }
                    
                    $diffHoursPM = floor($diffSecondsPM / 3600);
                    $diffMinutesPM = floor(($diffSecondsPM % 3600) / 60);
                    $diffSecondsPM = $diffSecondsPM % 60;

                    // compute total time difference
                    
                    $totalSeconds = $diffSecondsAM + $diffSecondsPM;
                    $totalMinutes = $diffMinutesAM + $diffMinutesPM + floor($totalSeconds / 60);
                    $totalHours = $diffHoursAM + $diffHoursPM + floor($totalMinutes / 60);

                    $totalMinutes = $totalMinutes % 60;
                    $totalSeconds = $totalSeconds % 60;


                    if(!empty($model->time_in_am))
                    {
                        if(empty($model->time_out_am))
                        {
                            $totalHours = 0;
                            $totalMinutes = 0;
                            $totalSeconds = 0;
                        }
                    }

                    if(!empty($model->time_in_pm))
                    {
                        if(empty($model->time_out_pm))
                        {
                            $totalHours = 0;
                            $totalMinutes = 0;
                            $totalSeconds = 0;
                        }
                    }

                    

                    if($totalHours > 0) 
                    {
                        $totalHoursRendered += $totalHours;
                    }
                    else
                    {
                        $totalHoursRendered += 0;
                    }

                    if($totalMinutes > 0)
                    {
                        $totalMinutesRendered += $totalMinutes;
                    }
                    else
                    {
                        $totalMinutesRendered += 0;
                    }

                    if($totalSeconds > 0)
                    {
                        $totalSecondsRendered += $totalSeconds;
                    }
                    else
                    {
                        $totalSecondsRendered += 0;
                    }

                    $sumTotal = (($totalHours > 0 ? $totalHours : 0) .' hrs ' ). (($totalMinutes > 0 ? $totalMinutes : 0).' min '). (($totalSeconds > 0 ? $totalSeconds : 0).' sec ');

                    // compute overtime if the total hours rendered is greater than 8 hours
                    $overtimeHours = $overtimeMinutes = $overtimeSeconds = 0;
                    if ($totalHours > 8) {
                        $overtimeSeconds = ($totalHours - 8) * 3600 + $totalMinutes * 60 + $totalSeconds;
                        $overtimeHours = floor($overtimeSeconds / 3600);
                        $overtimeMinutes = floor(($overtimeSeconds % 3600) / 60);
                        $overtimeSeconds = $overtimeSeconds % 60;
                        // subtract overtime from total hours rendered
                        $totalHours -= $overtimeHours;
                        $totalMinutes -= $overtimeMinutes;
                        $totalSeconds -= $overtimeSeconds;
                        // check for negative values and adjust the minutes and seconds accordingly
                        if ($totalSeconds < 0) {
                            $totalSeconds += 60;
                            $totalMinutes--;
                        }
                        if ($totalMinutes < 0) {
                            $totalMinutes += 60;
                            $totalHours--;
                        }
                    }


                    $overtime = ($overtimeHours > 0 ? $overtimeHours.' hrs ' : ''). ($overtimeMinutes > 0 ? $overtimeMinutes.' min ' : ''). ($overtimeSeconds > 0 ? $overtimeSeconds.' sec ' : '');


                    // TOTAL NO. OF HOURS_END

                        $formatted_in_am = !empty($model->time_in_am) ? date('g:i:s A', strtotime($model->time_in_am)) : "";
                        $formatted_out_am = !empty($model->time_out_am) ? date('g:i:s A', strtotime($model->time_out_am)) : "";
                        $formatted_in_pm = !empty($model->time_in_pm) ? date('g:i:s A', strtotime($model->time_in_pm)) : "";
                        $formatted_out_pm = !empty($model->time_out_pm) ? date('g:i:s A', strtotime($model->time_out_pm)) : "";

                        echo "<tr>";
                            echo "<td>" . Html::encode(date('j', strtotime($model->date))) . "</td>";
                            echo "<td>" . Html::encode($formatted_in_am) . "</td>";
                            echo "<td>" . Html::encode($formatted_out_am) . "</td>";
                            echo "<td>" . Html::encode($formatted_in_pm) . "</td>";
                            echo "<td>" . Html::encode($formatted_out_pm) . "</td>";
                            echo "<td>" . Html::encode($overtime) . "</td>";
                            echo "<td>" . Html::encode($sumTotal) . "</td>";
                            echo "<td>" . Html::encode($model->remarks) . "</td>";
                            echo "<td><a href='#' class='btn btn-secondary btn-sm'>VALIDATE</td>";
                            echo "<td>" . Html::a('REMARKS',['update', 'id' => $model->id],['class' => 'btn btn-sm btn-primary btn-sm']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    echo "<td>" . Html::encode(date('j', $date->getTimestamp())) . "</td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "</tr>";
                }
            }

            // $overallTotal = sprintf("%02d:%02d:%02d", $totalHours, $totalMinutes, $totalSeconds);

                // $seconds = $totalHoursRendered * 60 * 60 + $totalMinutesRendered * 60 + $totalSecondsRendered;
                // echo gmdate('H:i:s', $seconds);

                // $totalHoursRendered = 24;
                // $totalMinutesRendered = 117;
                // $totalSecondsRendered = 81;

                // $total_seconds = ($totalHoursRendered * 60 * 60) + ($totalMinutesRendered * 60) + $totalSecondsRendered;
                // $total_minutes = floor(($total_seconds / 60) % 60);
                // $total_hours = floor($total_seconds / 3600);
                // $total_minutes += ($total_seconds / 60) - ($total_hours * 60);
                // $total_hours += floor($total_minutes / 60);
                // $total_minutes %= 60;
                // $total_seconds %= 60;

                // $totalHoursRenderedRES = ($totalHoursRendered > 0) ? $totalHoursRendered : 0;
                // $totalMinutesRenderedRES = ($totalMinutesRendered > 0) ? $totalMinutesRendered : 0;
                // $totalSecondsRenderedRES = ($totalSecondsRendered > 0) ? $totalSecondsRendered : 0;

                $total_seconds = $totalHoursRendered * 3600 + $totalMinutesRendered * 60 + $totalSecondsRendered;
                $total_hours = floor($total_seconds / 3600);
                $total_minutes = floor(($total_seconds % 3600) / 60);
                $total_seconds = $total_seconds % 60;

                $sumTotalValue = $total_hours . " hours, " . $total_minutes . " minutes, and " . $total_seconds . " seconds";

            
                echo "<tr>";
                echo "<td colspan='6' style='text-align:right;'>TOTAL NO. OF HOURS FOR THIS MONTH</td>";
                echo "<td>".$sumTotalValue."</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "</tr>";
            echo "</tbody>";
            echo "</table>";
        ?>
    </div>




    <?php 
    // echo GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     // 'filterModel' => $searchModel,
    //     'columns' => [
    //         // ['class' => 'yii\grid\SerialColumn'],

    //         // 'id',
    //         // 'user_id',
    //         // [
    //         //     'attribute' => 'user_id',
    //         //     'value' => function($model)
    //         //     {
    //         //         return $model->user->fullName;
    //         //     }
    //         // ],
    //         // 'date',
    //         [
    //             'attribute' => 'date',
    //             'value' => function($model)
    //             {
    //                 return date('F j, Y', strtotime($model->date));
    //             }
    //         ],
    //         // 'time_in_am',
    //         // 'time_out_am',
    //         [
    //             'attribute' => 'time_in_am',
    //             'value' => function($model)
    //             {
    //                 $time = $model->time_in_am;
    //                 $formattedTime = date('g:i:s A', strtotime($time));
    //                 return !empty($model->time_in_am) ? $formattedTime : "";
    //             }
    //         ],
    //         [
    //             'attribute' => 'time_out_am',
    //             'value' => function($model)
    //             {
    //                 $time = $model->time_out_am;
    //                 $formattedTime = date('g:i:s A', strtotime($time));
    //                 return !empty($model->time_out_am) ? $formattedTime : "";
    //             }
    //         ],
    //         // 'time_in_pm',
    //         [
    //             'attribute' => 'time_in_pm',
    //             'value' => function($model)
    //             {
    //                 $time = $model->time_in_pm;
    //                 $formattedTime = date('g:i:s A', strtotime($time));
    //                 return !empty($model->time_in_pm) ? $formattedTime : "";
    //             }
    //         ],
    //         [
    //             'attribute' => 'time_out_pm',
    //             'value' => function($model)
    //             {
    //                 $time = $model->time_out_pm;
    //                 $formattedTime = date('g:i:s A', strtotime($time));
    //                 return !empty($model->time_out_pm) ? $formattedTime : "";
    //             }
    //         ],
    //         // 'time_out_pm',
    //         [
    //             'label' => 'Overtime',
    //             'value' => function($model)
    //             {
    //                 $time1_am = strtotime($model->time_in_am);
    //                 $time2_am = strtotime($model->time_out_am);
    //                 $time1_pm = strtotime($model->time_in_pm);
    //                 $time2_pm = strtotime($model->time_out_pm);

    //                 // compute AM time difference
    //                 $diffSecondsAM = $time2_am - $time1_am;
    //                 $diffHoursAM = floor($diffSecondsAM / 3600);
    //                 $diffMinutesAM = floor(($diffSecondsAM % 3600) / 60);
    //                 $diffSecondsAM = $diffSecondsAM % 60;

    //                 // compute PM time difference
    //                 $diffSecondsPM = $time2_pm - $time1_pm;
    //                 $diffHoursPM = floor($diffSecondsPM / 3600);
    //                 $diffMinutesPM = floor(($diffSecondsPM % 3600) / 60);
    //                 $diffSecondsPM = $diffSecondsPM % 60;

    //                 // compute total time difference
    //                 $totalSeconds = $diffSecondsAM + $diffSecondsPM;
    //                 $totalMinutes = $diffMinutesAM + $diffMinutesPM + floor($totalSeconds / 60);
    //                 $totalHours = $diffHoursAM + $diffHoursPM + floor($totalMinutes / 60);
    //                 $totalMinutes = $totalMinutes % 60;
    //                 $totalSeconds = $totalSeconds % 60;

                    
    //                 // compute overtime
    //                 if ($totalHours > 8) {
    //                     $overtimeHours = $totalHours - 8;
    //                     $returnVal = $overtimeHours . 'hrs ' . $totalMinutes . 'mins ' . $totalSeconds . ' secs';
    //                 } else {
    //                     $returnVal = '';
    //                 }

    //                 return $returnVal;

    //             }
    //         ],
    //         [
    //             'attribute' => 'Remarks',
    //             'value' => function($model)
    //             {
    //                 return !empty($model->remarks) ? $model->remarks : "";
    //             }
    //         ],
    //         [
    //             'label' => 'Total No. of Hours',
    //             'value' => function($model)
    //             {
    //                 $time1_am = strtotime($model->time_in_am);
    //                     $time2_am = strtotime($model->time_out_am);
    //                     $time1_pm = strtotime($model->time_in_pm);
    //                     $time2_pm = strtotime($model->time_out_pm);

    //                     // compute AM time difference
    //                     $diffSecondsAM = $time2_am - $time1_am;
    //                     $diffHoursAM = floor($diffSecondsAM / 3600);
    //                     $diffMinutesAM = floor(($diffSecondsAM % 3600) / 60);
    //                     $diffSecondsAM = $diffSecondsAM % 60;

    //                     // compute PM time difference
    //                     $diffSecondsPM = $time2_pm - $time1_pm;
    //                     $diffHoursPM = floor($diffSecondsPM / 3600);
    //                     $diffMinutesPM = floor(($diffSecondsPM % 3600) / 60);
    //                     $diffSecondsPM = $diffSecondsPM % 60;

    //                     // compute total time difference
    //                     $totalSeconds = $diffSecondsAM + $diffSecondsPM;
    //                     $totalMinutes = $diffMinutesAM + $diffMinutesPM + floor($totalSeconds / 60);
    //                     $totalHours = $diffHoursAM + $diffHoursPM + floor($totalMinutes / 60);
    //                     $totalMinutes = $totalMinutes % 60;
    //                     $totalSeconds = $totalSeconds % 60;

    //                     return ($totalHours > 0 ? $totalHours.' hrs ' : ''). ($totalMinutes > 0 ? $totalMinutes.' min ' : ''). ($totalSeconds > 0 ? $totalSeconds.' sec ' : '');
    //             }
    //         ],
            
    //         [
    //             'class' => ActionColumn::className(),
    //             'template' => '{update}',
    //             'urlCreator' => function ($action, UserTimesheet $model, $key, $index, $column) {
    //                 return Url::toRoute([$action, 'id' => $model->id]);
    //              }
    //         ],
    //     ],
    // ]); 
    ?>


</div>
