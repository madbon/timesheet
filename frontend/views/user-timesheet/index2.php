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

    /* TABLE SUMMARY DETAILS */
    table.summary-details
    {
        background: white;
    }
    table.summary-details tbody tr td
    {
        border:1px solid black;
        padding:5px;
        background:#ffe28b;
        
    }
    /* TABLE SUMMARY DETAILS_END */

</style>

<div class="user-timesheet-index">

    
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(!empty($model->user->id)){ ?>
    <div class="container">
        <div style="margin-top:20px; margin-bottom:20px;">
            <p>
                
            <?php
                if(count($queryYear) > 1)
                {
                    echo "SELECTED YEAR: ";
                    foreach ($queryYear as $keyear => $yearval) {
                        if($yearval['year'] == $year)
                        {
                            echo Html::a($yearval['year'],['index','month' => $month, 'month_id' => $month_id, 'year' => $yearval['year'],'trainee_user_id' => $model->user->id],['class' => 'btn btn-sm btn-warning']);
                        }
                        else
                        {
                            echo Html::a($yearval['year'],['index','month' => $month, 'month_id' => $month_id, 'year' => $yearval['year'],'trainee_user_id' => $model->user->id],['class' => 'btn btn-sm btn-outline-warning']);
                        }
                    }
                }
            ?>
            <?php
                echo "SELECTED MONTH: ";
                foreach ($queryMonth as $keymo => $mon) {
                    
                    if($mon['month'] == $month)
                    {
                        echo Html::a($mon['month'],['index','month' => $mon['month'], 'month_id' => $mon['month_id'], 'year' => $year,'trainee_user_id' => $model->user->id],['class' => 'btn btn-sm btn-warning']);
                    }
                    else
                    {
                        echo Html::a($mon['month'],['index','month' => $mon['month'], 'month_id' => $mon['month_id'],'year' => $year, 'trainee_user_id' => $model->user->id],['class' => 'btn btn-sm btn-outline-warning']);
                    }
                }
            ?>
            </p>
        </div>
        <div style="text-align:right;">
            <?= Html::a('PREVIEW PDF',['preview-pdf',
            'user_id' => $model->user->id,
            'year' => $year,
            'month' => $month,
            'month_id' => $month_id,
            ],['class' => 'btn btn-outline-danger btn-sm', 'target' => '_blank']); ?>
        </div>
        <h1 style="text-align: center; font-size:30px; font-weight:bold;">DAILY TIME RECORD</h1>

        <p style="text-align: center;">
            <?php // Yii::$app->user->can('record-time-in-out') ? Html::a("RECORD TIME", ['record'], ['class' => '']) : "" ?>
        </p>

        <table class="table-primary-details">
            <tbody>
                <tr>
                    <td style="font-weight:bold;">NAME:</td>
                    <td colspan="3" style="border-bottom:2px solid black; font-weight:bold; text-transform:uppercase;"><?= $model->user->userFullNameWithMiddleInitial; ?></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">MONTH:</td>
                    <td colspan="3" style="border-bottom:2px solid black; font-weight:bold;">
                        <?php // date('F', strtotime('M')) ?>
                        <?= $month ?>
                    </td>
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
            // print_r(date('m')); exit;
            $current_year = $year;
            $current_month = $month_id;

            $start_date = new DateTime("$current_year-$current_month-01");
            $end_date = new DateTime("$current_year-$current_month-01");
            $end_date->modify('last day of this month');

            $interval = new DateInterval('P1D');
            $date_range = new DatePeriod($start_date, $interval, $end_date->modify('+1 day')); // Add one day to include end date

            // Display the data in an HTML table
            echo "<table class='table table-bordered'>";
            echo "<thead>";
            echo "<tr>
                    <th style='border-left:1px solid #f5f6ff; background-color:#f5f6ff; border-top:1px solid #f5f6ff;'></th>
                    <th colspan='2'>AM</th>
                    <th colspan='2'>PM</th>
                    <th colspan='5' style='border-top:1px solid #f5f6ff; border-right:1px solid #f5f6ff; background:#f5f6ff;'></th>
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
                    ".(Yii::$app->user->can('timesheet-remarks') || Yii::$app->user->can('edit-time') ? "<th></th>" : "")."
            </tr>";
            echo "</thead>";
            echo "<tbody>";

            $totalHoursRendered = 0;
            $totalMinutesRendered = 0;
            $totalSecondsRendered = 0;
            $countPendingRecord = 0;
            $total_minutes = 0;
            $totalMinutesOvertime = 0;

            foreach ($date_range as $date) {
                $models = UserTimesheet::findAll([
                    'date' => $date->format('Y-m-d'), 
                    'user_id' => $model->user->id
                ]); // Retrieve all models for date

                if ($models) {

                    $countCompleteTime = 0;
                    

                    foreach ($models as $model) {

                    if(empty($model->status))
                    {
                        $countPendingRecord += 1;
                    }

                    // TOTAL NO. OF HOURS_END
                        $formatted_in_am = !empty($model->time_in_am) ? date('g:i:s A', strtotime($model->time_in_am)) : "";
                        $formatted_out_am = !empty($model->time_out_am) ? date('g:i:s A', strtotime($model->time_out_am)) : "";
                        $formatted_in_pm = !empty($model->time_in_pm) ? date('g:i:s A', strtotime($model->time_in_pm)) : "";
                        $formatted_out_pm = !empty($model->time_out_pm) ? date('g:i:s A', strtotime($model->time_out_pm)) : "";

                        $start_time = !empty($model->time_in_am) ? new DateTime($formatted_in_am) : new DateTime($formatted_in_pm);
                        $end_time = !empty($model->time_out_pm) ? new DateTime($formatted_out_pm) : new DateTime($formatted_out_am);
                        
                        // Check if the start time is between 12:00 PM and 12:59 PM
                        if (new DateTime($start_time->format('g:i A')) >= new DateTime('12:00 PM') && new DateTime( $start_time->format('g:i A')) <= new DateTime('12:59 PM')) {
                            $start_time = new DateTime('1:00 PM');
                        }
                        
                        // Check if the end time is between 12:00 PM and 12:59 PM
                        if (new DateTime($end_time->format('g:i A')) >= new DateTime('12:00 PM') && new DateTime($end_time->format('g:i A')) <= new DateTime('12:59 PM')) {
                            $end_time = new DateTime('12:00 PM');
                        }
                        
                        // Check if the end time is greater than 1:00 PM
                        // print_r($end_time->format('g:i A')); exit;
                        if (new DateTime($end_time->format('g:i A')) >= new DateTime('01:00 PM')) {
                            // Subtract one hour from the end time

                            if(!empty($model->time_in_am))
                            {
                                $end_time->modify('-1 hour');
                            }
                        }
                        
                      
                        $interval = $end_time->diff($start_time);
                       
                        // Calculate the total duration in minutes
                        $total_minutes = $interval->h * 60 + $interval->i;

                        $totalMinutesRendered += $interval->h * 60 + $interval->i;

                        // Check if the total duration is greater than 8 hours
                        $overtime_hours = 0;
                        $overtime_minutes = 0;
                        if ($total_minutes > 8 * 60) {
                            // Calculate the overtime in minutes
                            $overtime_minutes = $total_minutes - 8 * 60;
                            $totalMinutesOvertime += $total_minutes - 8 * 60;
                            
                            // Convert the overtime to hours and minutes
                            $overtime_hours = floor($overtime_minutes / 60);
                            $overtime_minutes = $overtime_minutes % 60;
                            
                            // Output the overtime
                            // echo "\nYou have {$overtime_hours} hours and {$overtime_minutes} minutes of overtime.";
                        }

                        echo "<tr>";
                            echo "<td>" . Html::encode(date('j', strtotime($model->date))) . "</td>";
                            echo "<td>" . Html::encode($formatted_in_am) . "</td>";
                            echo "<td>" . Html::encode($formatted_out_am) . "</td>";
                            echo "<td>" . Html::encode($formatted_in_pm) . "</td>";
                            echo "<td>" . Html::encode($formatted_out_pm) . "</td>";
                            

                            if(empty($model->time_out_am) && empty($model->time_out_pm))
                            {
                                echo "<td></td>";
                                echo "<td></td>";
                            }
                            else
                            {
                                echo "<td>" . ($overtime_hours." hrs. ".$overtime_minutes." mins. ") . "</td>";
                                echo "<td>" . ($interval->h. " hrs. ". $interval->i." mins. ") . "</td>";
                            }
                            

                            echo "<td>" . Html::encode($model->remarks) . "</td>";

                            if($model->time_in_am)
                            {
                                $countCompleteTime += 1;
                            }

                            if($model->time_out_am)
                            {
                                $countCompleteTime += 1;
                            }

                            if($model->time_in_pm)
                            {
                                $countCompleteTime += 1;
                            }

                            if($model->time_out_pm)
                            {
                                $countCompleteTime += 1;
                            }

                            if(Yii::$app->user->can('validate-timesheet'))
                            {
                                if($model->status)
                                {

                                    echo "<td>";
                                    
                                    echo Html::a('VALIDATED',['validate-timesheet','id' => $model->id],['class' => 'btn btn-success btn-sm']);
                                    echo "</td>";
                                }
                                else{
                                    echo "<td>";
                                    echo Html::a('VALIDATE',['validate-timesheet','id' => $model->id],['class' => 'btn btn-outline-success btn-sm']);
                                    echo "</td>";
                                }
                            }
                            else
                            {
                                if($model->status)
                                {
                                    echo "<td style='color:green;'>VALIDATED</td>";
                                }
                                else{
                                    echo "<td style='color:orange;'>PENDING</td>";
                                }
                            }
                            
                            if(Yii::$app->user->can('timesheet-remarks'))
                            {
                                echo "<td>";
                                if(Yii::$app->user->can('edit-time'))
                                {
                                    if(empty($model->status))
                                    {
                                        echo Html::a('EDIT TIME',['update-timeout','id' => $model->id,'count_complete_time' => $countCompleteTime],['class' => 'btn btn-outline-primary btn-sm'])." ";
                                    }
                                }
                                echo Html::a('EDIT REMARKS',['update', 'id' => $model->id],['class' => 'btn btn-sm btn-outline-primary btn-sm']) . "</td>";
                            }
                            else
                            {
                                if(Yii::$app->user->can('edit-time'))
                                {
                                    echo "<td>";
                                    if(empty($model->status))
                                    {
                                        echo Html::a('EDIT TIME',['update-timeout','id' => $model->id,'count_complete_time' => $countCompleteTime],['class' => 'btn btn-outline-primary btn-sm']);
                                    }
                                    echo "</td>";
                                }
                            }
                            
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
                    // echo "<td></td>";
                    echo "</tr>";
                }
            }

            $total_hours_val = floor($totalMinutesRendered / 60);
            $totalMinutesRendered = $totalMinutesRendered % 60;

            $total_hours_ot = floor($totalMinutesOvertime / 60);
            $totalMinutesOvertime = $totalMinutesOvertime % 60;

            echo "<tr>";
            echo "<td colspan='5' style='font-weight:bold; text-align:right; text-transform:uppercase;'> TOTAL NO. OF HOURS RENDERED FOR THE MONTH OF {$month}</td>";
            echo "<td>".($total_hours_ot." hrs. ".$totalMinutesOvertime." mins.")."</td>";
            echo "<td>".($total_hours_val." hrs. ".$totalMinutesRendered." mins.")."</td>";
            echo "<td></td>";
            echo "<td></td>";
            // echo "<td></td>";
            echo "</tr>";

            echo "</tbody>";
            echo "</table>";
        ?>

        <table>
            <tbody>
                <tr>
                    <td style="display: flex; justify-content: center; align-items: center;">
                        <?php
                            $uploadedFileName = Yii::$app->getModule('admin')->GetFileNameExt('UserData',$model->user->id);

                            $uploadedFile = Yii::$app->getModule('admin')->GetFileUpload('UserData',$model->user->id);
                
                            if(Yii::$app->getModule('admin')->FileExists($uploadedFileName)) 
                            {
                                echo Html::img(Yii::$app->request->baseUrl.$uploadedFile, ['alt'=>'My Image', 'style' => '', 'height' => '100', 'width' => '100']);
                            }
                            else
                            {
                                echo "NO UPLOADED E-SIGNATURE";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid black; text-align:center; font-size:15px; "><?= !empty($model->user->UserFullNameWithMiddleInitial) ? $model->user->UserFullNameWithMiddleInitial : "" ?></td>
                </tr>
                <tr>
                    <td style="font-size:11px; font-weight:bold; text-align:center;">Intern Signature over printed name</td>
                </tr>
                <tr>
                    <td style="display: flex; justify-content: center; align-items: center;">
                        <?php
                            if(empty($countPendingRecord))
                            {
                                $uploadedFileNameCP = Yii::$app->getModule('admin')->GetFileNameExt('UserData',$model->user->id);

                                $uploadedFileCP = Yii::$app->getModule('admin')->GetFileUpload('UserData',Yii::$app->getModule('admin')->GetSupervisorIdByTraineeUserId($model->user_id));
                    
                                if(Yii::$app->getModule('admin')->FileExists($uploadedFileNameCP)) 
                                {
                                    echo Html::img(Yii::$app->request->baseUrl.$uploadedFileCP, ['alt'=>'My Image', 'style' => '', 'height' => '100', 'width' => '100']);
                                }
                                else
                                {
                                    echo "NO UPLOADED E-SIGNATURE";
                                }
                            }
                            else
                            {
                                echo "<div style='height:50px;'></div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid black; text-align:center; font-weight:bold; text-transform:uppercase; font-size:15px;"><?= Yii::$app->getModule('admin')->GetSupervisorByTraineeUserId($model->user_id); ?></td>
                </tr>
                <tr>
                    <td style="font-size:11px; font-weight:bold;">Immidiate Supervisor Signature over printed name</td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } else{ ?>

        <h3 style="text-align: center;">
            You have no record of time in/out for this month
                <?php //  Yii::$app->user->can('record-time-in-out') ? Html::a("RECORD TIME IN/OUT", ['time-in'], ['class' => 'btn btn-outline-warning']) : "" ?>
        </h3>

    <?php } ?>
    
   <?php if(!empty($model->user->id)){ ?>
            <?php
            $totalHoursRendered2 = 0;
            $totalMinutesRendered2 = 0;
            $totalSecondsRendered2 = 0;
            $countPendingRecord2 = 0;
            $total_minutes2 = 0;
            $totalMinutesOvertime2 = 0;
            $march_total = 0;
            $april_total = 0;
            $may_total = 0;
            $june_total = 0;
            $july_total = 0;


                $querySummary = UserTimesheet::find()
                ->select([
                    '*',
                    'YEAR(date) as year_val',
                    'MONTH(date) as month_val',
                ])
                ->where([
                    'user_id' => $model->user->id,
                ])
                ->andWhere(['YEAR(date)' => $year])
                // ->andWhere(['MONTH(date)' => $month_id])
                ->all();
                // ->createCommand()->rawSql;

                // print_r($querySummary); exit;

            ?>

            <?php foreach ($querySummary as $model2) { 
               
                ?>
                <?php
                    $formatted_in_am2 = !empty($model2->time_in_am) ? date('g:i:s A', strtotime($model2->time_in_am)) : "";
                    $formatted_out_am2 = !empty($model2->time_out_am) ? date('g:i:s A', strtotime($model2->time_out_am)) : "";
                    $formatted_in_pm2 = !empty($model2->time_in_pm) ? date('g:i:s A', strtotime($model2->time_in_pm)) : "";
                    $formatted_out_pm2 = !empty($model2->time_out_pm) ? date('g:i:s A', strtotime($model2->time_out_pm)) : "";

                    $start_time2 = !empty($model2->time_in_am) ? new DateTime($formatted_in_am2) : new DateTime($formatted_in_pm2);
                    $end_time2 = !empty($model2->time_out_pm) ? new DateTime($formatted_out_pm2) : new DateTime($formatted_out_am2);
                    
                    // Check if the start time is between 12:00 PM and 12:59 PM
                    if (new DateTime($start_time2->format('g:i A')) >= new DateTime('12:00 PM') && new DateTime( $start_time2->format('g:i A')) <= new DateTime('12:59 PM')) {
                        $start_time2 = new DateTime('1:00 PM');
                    }
                    
                    // Check if the end time is between 12:00 PM and 12:59 PM
                    if (new DateTime($end_time2->format('g:i A')) >= new DateTime('12:00 PM') && new DateTime($end_time2->format('g:i A')) <= new DateTime('12:59 PM')) {
                        $end_time2 = new DateTime('12:00 PM');
                    }
                    
                    // Check if the end time is greater than 1:00 PM
                    // print_r($end_time->format('g:i A')); exit;
                    if (new DateTime($end_time2->format('g:i A')) >= new DateTime('01:00 PM')) {
                        // Subtract one hour from the end time

                        if(!empty($model2->time_in_am))
                        {
                            $end_time2->modify('-1 hour');
                        }
                    }
                    
                  
                    $interval2 = $end_time2->diff($start_time2);
                   
                    // Calculate the total duration in minutes
                    $total_minutes2 = $interval2->h * 60 + $interval->i;

                    $totalMinutesRendered2 += $interval2->h * 60 + $interval2->i;

                    switch ($model2->month_val) {
                        case '3':
                            $march_total += $interval2->h * 60 + $interval2->i; 
                        break;
                        case '4':
                            $april_total += $interval2->h * 60 + $interval2->i; 
                        break;
                        case '5':
                            $may_total += $interval2->h * 60 + $interval2->i; 
                        break;
                        case '6':
                            $june_total += $interval2->h * 60 + $interval2->i; 
                        break;
                        case '7':
                            $july_total += $interval2->h * 60 + $interval2->i; 
                        break;
                        
                        default:
                            # code...
                            break;
                    }
                    
                    // Check if the total duration is greater than 8 hours
                    $overtime_hours2 = 0;
                    $overtime_minutes2 = 0;
                    if ($total_minutes2 > 8 * 60) {
                        // Calculate the overtime in minutes
                        $overtime_minutes2 = $total_minutes2 - 8 * 60;
                        $totalMinutesOvertime2 += $total_minutes2 - 8 * 60;
                        
                        // Convert the overtime to hours and minutes
                        $overtime_hours2 = floor($overtime_minutes2 / 60);
                        $overtime_minutes2 = $overtime_minutes2 % 60;
                        
                        // Output the overtime
                        // echo "\nYou have {$overtime_hours} hours and {$overtime_minutes} minutes of overtime.";
                    }
                ?>
                
            <?php } ?>
            <?php
            
                 $total_hours_val2 = floor($totalMinutesRendered2 / 60);
                 $totalMinutesRendered2 = $totalMinutesRendered2 % 60;
     
                 $total_hours_ot2 = floor($totalMinutesOvertime2 / 60);
                 $totalMinutesOvertime2 = $totalMinutesOvertime2 % 60;

                 $totalMarch = floor($march_total / 60);
                 $march_total = $march_total % 60;

                 $totalApril = floor($april_total / 60);
                 $april_total = $april_total % 60;

                 $totalMay = floor($may_total / 60);
                 $may_total = $may_total % 60;

                 $totalJune = floor($june_total / 60);
                 $june_total = $june_total % 60;

                 $totalJuly = floor($july_total / 60);
                 $july_total = $july_total % 60;
            ?>
        
    <hr/>
    <div style="background:white;">
    <h6 style="text-align: center; font-weight:bold;">INTERNSHIP SUMMARY BOARD</h6>
    <table class="table table-bordered summary-details">
        <tbody>
            <tr>
                <td colspan="5" style="border-top:none; border-left:none; border-right:none; font-weight:bold;">SUMMARY OF HOURS RENDERED</td>
            </tr>
            <tr>
                <td>MARCH</td>
                <td><?= $totalMarch; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>APRIL</td>
                <td><?= $totalApril; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>MAY</td>
                <td><?= $totalMay; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>JUNE</td>
                <td><?= $totalJune; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>JULY</td>
                <td><?= $totalJuly; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>TOTAL HOURS REQUIRED</td>
                <td style="font-weight:bold;"><?= $model->user->program->required_hours ?></td>
            </tr>
            <tr>
                <td>TOTAL HOURS RENDERED</td>
                <td style="font-weight:bold;"><?= $total_hours_val2; ?></td>
            </tr>
            <tr>
                <td>TOTAL HOURS REMAINED</td>
                <td style="font-weight:bold;"><?= ($model->user->program->required_hours - (int)$total_hours_val2) ?></td>
            </tr>
        </tbody>
    </table>
    </div>
    <?php } ?>

</div>
