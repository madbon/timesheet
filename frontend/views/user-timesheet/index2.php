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
// $this->params['breadcrumbs'][] = $this->title;
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
            <?= Html::a('<i class="fas fa-file-pdf"></i> PREVIEW PDF',['preview-pdf',
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
                    ".(Yii::$app->user->can('timesheet-remarks') || Yii::$app->user->can('edit-time') ? "<th>AVAILABLE ACTIONS</th>" : "")."
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

                        

                        $start_time = new DateTime($formatted_in_am);
                        $end_time = new DateTime($formatted_out_am);

                        $start_time2 = new DateTime($formatted_in_pm);
                        $end_time2 = new DateTime($formatted_out_pm);

                        $interval = $end_time->diff($start_time);
                        $interval2 = $end_time2->diff($start_time2);

                        if($model->time_in_am && $model->time_out_am && $model->time_in_pm && $model->time_out_pm)
                        { // 1-1-1-1

                            if(new DateTime($formatted_out_pm) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm) < new DateTime('1:00 PM'))
                            {
                                $end_time2 = new DateTime('12:00 PM');
                            }

                            if(new DateTime($formatted_in_pm) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm) < new DateTime('1:00 PM'))
                            { // time_in_pm (between 12 and 12:59pm)
                                $start_time2 = new DateTime('12:00 PM');
                                $end_time2 = new DateTime('12:00 PM');
                            }

                            if(new DateTime($formatted_in_pm) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm) >= new DateTime('1:00 PM'))
                            {
                                if(new DateTime($formatted_in_pm) > new DateTime('1:00 PM'))
                                {
                                    $start_time2 = new DateTime($formatted_in_pm);
                                }
                                else
                                {
                                    $start_time2 = new DateTime('01:00 PM');
                                }
                                
                            }

                            $interval = $end_time->diff($start_time);
                            $interval2 = $end_time2->diff($start_time2);
                        }
                        else
                        {
                            // Check if the start time is between 12:00 PM and 12:59 PM

                            if(empty($model->time_in_am) && empty($model->time_out_am) && $model->time_in_pm && $model->time_out_pm)
                            { // 0-0-1-1
                                
                                if(new DateTime($formatted_out_pm) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm) < new DateTime('1:00 PM'))
                                {
                                    $end_time2 = new DateTime('12:00 PM');
                                }

                                if(new DateTime($formatted_in_pm) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm) < new DateTime('1:00 PM'))
                                { // time_in_pm (between 12 and 12:59pm)
                                    $start_time2 = new DateTime('12:00 PM');
                                    $end_time2 = new DateTime('12:00 PM');
                                }

                                if(new DateTime($formatted_in_pm) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm) >= new DateTime('1:00 PM'))
                                {
                                    if(new DateTime($formatted_in_pm) > new DateTime('1:00 PM'))
                                    {
                                        $start_time2 = new DateTime($formatted_in_pm);
                                    }
                                    else
                                    {
                                        $start_time2 = new DateTime('01:00 PM');
                                    }
                                    
                                }

                                $interval = $end_time->diff($start_time);
                                $interval2 = $end_time2->diff($start_time2);
                            }
                            else
                            {
                                if($model->time_in_am && empty($model->time_out_am) &&  empty($model->time_in_pm) && $model->time_out_pm)
                                { // 1-0-0-1
                                    $start_time = new DateTime($formatted_in_am);
                                    $end_time = new DateTime('12:00 PM');

                                    if(new DateTime($formatted_out_pm) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm) < new DateTime('1:00 PM'))
                                    {
                                        $start_time2 = new DateTime('12:00 PM');
                                        $end_time2 = new DateTime('12:00 PM');
                                    }
                                    else
                                    {
                                        $start_time2 = new DateTime('1:00 PM');
                                        $end_time2 = new DateTime($formatted_out_pm);
                                    }

                                    $interval = $end_time->diff($start_time);
                                    $interval2 = $end_time2->diff($start_time2);

                                }
                            }
                        }

                        $total_minutes = $model->status ? $interval->h * 60 + $interval->i : 0;

                        $total_minutes2 = $model->status ? $interval2->h * 60 + $interval2->i : 0;

                        $totalMinutesRendered += ($total_minutes + $total_minutes2);

                        // OT
                        $total_minutesOT = $interval->h * 60 + $interval->i;

                        $total_minutes2OT = $interval2->h * 60 + $interval2->i;
                        // OT-end

                        $main_total_minutes = $total_minutesOT + $total_minutes2OT;

                        
                        
                        // Check if the total duration is greater than 8 hours
                        $overtime_hours = 0;
                        $overtime_minutes = 0;
                        if ($main_total_minutes > 8 * 60) {
                            // Calculate the overtime in minutes
                            $overtime_minutes = $main_total_minutes - 8 * 60;

                            if($model->status)
                            {
                                $totalMinutesOvertime += $main_total_minutes - 8 * 60;
                            }
                            // Convert the overtime to hours and minutes
                            $overtime_hours = floor($overtime_minutes / 60);
                            $overtime_minutes = $overtime_minutes % 60;
                            
                        }

                        $view_photo_in_am = !empty($model->time_in_am) ? Html::button($formatted_in_am, ['value'=>Url::to('@web/user-timesheet/preview-photo?timesheet_id='.$model->id.'&time='.$model->time_in_am), 'class' => 'btn btn-outline-dark btn-sm modalButton','style' => 'border:none;']) : "";

                        $view_photo_out_am = !empty($model->time_out_am) ? Html::button($formatted_out_am, ['value'=>Url::to('@web/user-timesheet/preview-photo?timesheet_id='.$model->id.'&time='.$model->time_out_am), 'class' => 'btn btn-outline-dark btn-sm modalButton','style' => 'border:none;']) : "";

                        $view_photo_in_pm = !empty($model->time_in_pm) ? Html::button($formatted_in_pm, ['value'=>Url::to('@web/user-timesheet/preview-photo?timesheet_id='.$model->id.'&time='.$model->time_in_pm), 'class' => 'btn btn-outline-dark btn-sm modalButton','style' => 'border:none;']) : "";

                        $view_photo_out_pm = !empty($model->time_out_pm) ? Html::button($formatted_out_pm, ['value'=>Url::to('@web/user-timesheet/preview-photo?timesheet_id='.$model->id.'&time='.$model->time_out_pm), 'class' => 'btn btn-outline-dark btn-sm modalButton','style' => 'border:none;']) : "";

                        echo "<tr>";
                            echo "<td>" . Html::encode(date('j', strtotime($model->date))) . "</td>";
                            echo "<td>" . ($view_photo_in_am) . "</td>";
                            echo "<td>" . ($view_photo_out_am).  "</td>";
                            echo "<td>" . ($view_photo_in_pm) . "</td>";
                            echo "<td>" . ($view_photo_out_pm) . "</td>";

                            echo "<td>" . ($overtime_hours." hrs. ".$overtime_minutes." mins. ") . "</td>";
                            echo "<td>" . (($interval->h + $interval2->h). " hrs. ". ($interval->i + $interval2->i)." mins. ") . "</td>";
                            

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
                                    
                                    echo Html::a('<i class="fas fa-undo"></i> VALIDATED',['validate-timesheet','id' => $model->id],['class' => 'btn btn-primary btn-sm']);
                                    echo "</td>";
                                }
                                else{
                                    echo "<td>";
                                    echo Html::a('<i class="fas fa-thumbs-up"></i> VALIDATE',['validate-timesheet','id' => $model->id],['class' => 'btn btn-outline-primary btn-sm']);
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
                                        // echo Html::a('<i class="fas fa-edit"></i> TIME',['update-timeout','id' => $model->id,'count_complete_time' => $countCompleteTime],['class' => 'btn btn-outline-primary btn-sm'])." ";

                                        echo Html::button('<i class="fas fa-edit"></i> TIME', ['value'=>Url::to('@web/user-timesheet/update-timeout?id='.$model->id.'&count_complete_time='.$countCompleteTime), 'class' => 'btn btn-outline-dark btn-sm modalButton','style' => ''])." ";
                                    }
                                }

                                if(empty($model->status))
                                {
                                    echo Html::button('<i class="fas fa-edit"></i> REMARKS', ['value'=>Url::to('@web/user-timesheet/update?id='.$model->id), 'class' => 'btn btn-outline-dark btn-sm modalButton','style' => '']) . "</td>";
                                }
                                
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
                    echo Yii::$app->user->can('timesheet-remarks') || Yii::$app->user->can('edit-time') ? "<td></td>" : "";
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
            echo Yii::$app->user->can('timesheet-remarks') || Yii::$app->user->can('edit-time') ? "<td></td>" : "";
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
                                echo Html::img(Yii::$app->request->baseUrl.$uploadedFile, ['alt'=>'Signature', 'style' => '', 'height' => '100', 'width' => '100']);
                            }
                            else
                            {
                                echo "NO UPLOADED E-SIGNATURE";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid black; text-align:center; font-size:15px; text-transform:uppercase;"><?= !empty($model->user->UserFullNameWithMiddleInitial) ? $model->user->UserFullNameWithMiddleInitial : "" ?></td>
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
                                    echo Html::img(Yii::$app->request->baseUrl.$uploadedFileCP, ['alt'=>'Signature', 'style' => '', 'height' => '100', 'width' => '100']);
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
                    <td style="font-size:11px; font-weight:bold;">Immediate Supervisor Signature over printed name</td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } else{ ?>

        <h3 style="text-align: center;">
            You have no record of time in/out
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
            
            
            
            $jan_total = 0;
            $feb_total = 0;
            $march_total = 0;
            $april_total = 0;
            $may_total = 0;
            $june_total = 0;
            $july_total = 0;
            $aug_total = 0;
            $sept_total = 0;
            $oct_total = 0;
            $nov_total = 0;
            $dec_total = 0;


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

                    

                    $start_time3 = new DateTime($formatted_in_am2);
                    $end_time3 = new DateTime($formatted_out_am2);

                    $start_time2 = new DateTime($formatted_in_pm2);
                    $end_time2 = new DateTime($formatted_out_pm2);

                    $interval3 = $end_time3->diff($start_time3);
                    $interval2 = $end_time2->diff($start_time2);

                    if($model2->time_in_am && $model2->time_out_am && $model2->time_in_pm && $model2->time_out_pm)
                    { // 1-1-1-1

                        if(new DateTime($formatted_out_pm2) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm2) < new DateTime('1:00 PM'))
                        {
                            $end_time2 = new DateTime('12:00 PM');
                        }

                        if(new DateTime($formatted_in_pm) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm2) < new DateTime('1:00 PM'))
                        { // time_in_pm (between 12 and 12:59pm)
                            $start_time2 = new DateTime('12:00 PM');
                            $end_time2 = new DateTime('12:00 PM');
                        }

                        if(new DateTime($formatted_in_pm2) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm2) >= new DateTime('1:00 PM'))
                        {
                            if(new DateTime($formatted_in_pm2) > new DateTime('1:00 PM'))
                            {
                                $start_time2 = new DateTime($formatted_in_pm2);
                            }
                            else
                            {
                                $start_time2 = new DateTime('01:00 PM');
                            }
                            
                        }

                        $interval3 = $end_time3->diff($start_time3);
                        $interval2 = $end_time2->diff($start_time2);
                    }
                    else
                    {
                        // Check if the start time is between 12:00 PM and 12:59 PM

                        if(empty($model2->time_in_am) && empty($model2->time_out_am) && $model2->time_in_pm && $model2->time_out_pm)
                        { // 0-0-1-1
                            
                            if(new DateTime($formatted_out_pm2) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm2) < new DateTime('1:00 PM'))
                            {
                                $end_time2 = new DateTime('12:00 PM');
                            }

                            if(new DateTime($formatted_in_pm2) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm2) < new DateTime('1:00 PM'))
                            { // time_in_pm (between 12 and 12:59pm)
                                $start_time2 = new DateTime('12:00 PM');
                                $end_time2 = new DateTime('12:00 PM');
                            }

                            if(new DateTime($formatted_in_pm2) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm2) >= new DateTime('1:00 PM'))
                            {
                                if(new DateTime($formatted_in_pm2) > new DateTime('1:00 PM'))
                                {
                                    $start_time2 = new DateTime($formatted_in_pm2);
                                }
                                else
                                {
                                    $start_time2 = new DateTime('01:00 PM');
                                }
                                
                            }

                            $interval3 = $end_time3->diff($start_time3);
                            $interval2 = $end_time2->diff($start_time2);
                        }
                        else
                        {
                            if($model2->time_in_am && empty($model2->time_out_am) &&  empty($model2->time_in_pm) && $model2->time_out_pm)
                            { // 1-0-0-1
                                $start_time3 = new DateTime($formatted_in_am2);
                                $end_time3 = new DateTime('12:00 PM');

                                if(new DateTime($formatted_out_pm2) >= new DateTime('12:00 PM') && new DateTime($formatted_out_pm2) < new DateTime('1:00 PM'))
                                {
                                    $start_time2 = new DateTime('12:00 PM');
                                    $end_time2 = new DateTime('12:00 PM');
                                }
                                else
                                {
                                    $start_time2 = new DateTime('1:00 PM');
                                    $end_time2 = new DateTime($formatted_out_pm2);
                                }

                                $interval3 = $end_time3->diff($start_time3);
                                $interval2 = $end_time2->diff($start_time2);

                            }
                        }
                    }
                    
                    

                    $total_minutes2 = $model2->status ? $interval3->h * 60 + $interval->i : 0;
                    $total_minutes1 = $model2->status ? $interval2->h * 60 + $interval2->i : 0;

                    $totalMinutesRendered2 += ($total_minutes2 + $total_minutes1);
                    
                  
                    switch ($model2->month_val) {
                        case '1':
                            if($model2->status)
                            {
                                $jan_total  += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                            }
                        break;
                        case '2':
                            
                            $feb_total  += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                        break;
                        case '3':
                            $march_total  += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                        break;
                        case '4':
                            $april_total += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                        break;
                        case '5':
                            $may_total += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                        break;
                        case '6':
                            $june_total += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                        break;
                        case '7':
                            $july_total += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                        break;
                        case '8':
                            $aug_total += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                        break;
                        case '9':
                            $sept_total += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                        break;
                        case '10':
                            $oct_total += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                        break;
                        case '11':
                            $nov_total += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                        break;
                        case '12':
                            $dec_total += (($interval3->h * 60) + ($interval2->h * 60)) + ($interval3->i + $interval2->i); 
                        break;
                        
                        default:
                            # code...
                            break;
                    }
                
                ?>
                
            <?php } ?>
            <?php

                // $total_hours_val = floor($totalMinutesRendered / 60);
                // $totalMinutesRendered = $totalMinutesRendered % 60;
            
                //  $total_hours_val2 = floor($totalMinutesRendered2 / 60);
                //  $totalMinutesRendered2 = $totalMinutesRendered2 % 60;
     
                 $total_hours_ot2 = floor($totalMinutesOvertime2 / 60);
                 $totalMinutesOvertime2 = $totalMinutesOvertime2 % 60;

                $totalOverall = floor(($jan_total + $feb_total +$march_total + $april_total + $may_total + $june_total + $july_total + $aug_total + $sept_total + $oct_total + $nov_total + $dec_total) / 60);
                // $overAllTotal = ($march_total + $april_total + $may_total + $june_total + $july_total) % 60;

                $totalJan = floor($jan_total / 60); // total of hours
                $jan_total = $jan_total % 60; // total of minutes

                $totalFeb = floor($feb_total / 60); // total of hours
                $feb_total = $feb_total % 60; // total of minutes

                $totalMarch = floor($march_total / 60); // total of hours
                $march_total = $march_total % 60; // total of minutes

                $totalApril = floor($april_total / 60); // total of hours
                $april_total = $april_total % 60; // total of minutes

                $totalMay = floor($may_total / 60); // total of hours
                $may_total = $may_total % 60; // total of minutes

                $totalJune = floor($june_total / 60); // total of hours
                $june_total = $june_total % 60; // total of minutes

                $totalJuly = floor($july_total / 60); // total of hours
                $july_total = $july_total % 60; // total of minutes

                $totalAug = floor($aug_total / 60); // total of hours
                $aug_total = $aug_total % 60; // total of minutes

                $totalSept = floor($sept_total / 60); // total of hours
                $sept_total = $sept_total % 60; // total of minutes

                $totalOct = floor($oct_total / 60); // total of hours
                $oct_total = $oct_total % 60; // total of minutes

                $totalNov = floor($nov_total / 60); // total of hours
                $nov_total = $nov_total % 60; // total of minutes

                $totalDec = floor($dec_total / 60); // total of hours
                $dec_total = $dec_total % 60; // total of minutes

                $overAllTotal = floor(($jan_total + $feb_total +$march_total + $april_total + $may_total + $june_total + $july_total + $aug_total + $sept_total + $oct_total + $nov_total + $dec_total) / 60);
            ?>
        
    <hr/>
    <div style="background:white;">
    <h6 style="text-align: center; font-weight:bold;">INTERNSHIP SUMMARY BOARD</h6>
    <table class="table table-bordered summary-details">
        <tbody>
            <tr>
                <td colspan="5" style="border-top:none; border-left:none; border-right:none; font-weight:bold;">SUMMARY OF HOURS RENDERED</td>
            </tr>

            <?php if($jan_total){ ?>
            <tr>
                <td>JANUARY</td>
                <td><?= $totalJan. " hr/s ".$jan_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <?php if($feb_total){ ?>
            <tr>
                <td>FEBRUARY</td>
                <td><?= $totalFeb. " hr/s ".$feb_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <?php if($march_total){ ?>
            <tr>
                <td>MARCH</td>
                <td><?= $totalMarch. " hr/s ".$march_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <?php if($april_total){ ?>
            <tr>
                <td>APRIL</td>
                <td><?= $totalApril. " hr/s ".$april_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <?php if($may_total){ ?>
            <tr>
                <td>MAY</td>
                <td><?= $totalMay. " hr/s ".$may_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <?php if($june_total){ ?>
            <tr>
                <td>JUNE</td>
                <td><?= $totalJune. " hr/s ".$june_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <?php if($july_total){ ?>
            <tr>
                <td>JULY</td>
                <td><?= $totalJuly. " hr/s ".$july_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <?php if($aug_total){ ?>
            <tr>
                <td>AUGUST</td>
                <td><?= $totalAug. " hr/s ".$aug_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <?php if($sept_total){ ?>
            <tr>
                <td>SEPTEMBER</td>
                <td><?= $totalSept. " hr/s ".$sept_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <?php if($oct_total){ ?>
            <tr>
                <td>OCTOBER</td>
                <td><?= $totalOct. " hr/s ".$oct_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <?php if($nov_total){ ?>
            <tr>
                <td>NOVEMBER</td>
                <td><?= $totalNov. " hr/s ".$nov_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <?php if($dec_total){ ?>
            <tr>
                <td>DECEMBER</td>
                <td><?= $totalDec. " hr/s ".$dec_total." min/s "; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>

            <tr>
                <td>TOTAL HOURS REQUIRED</td>
                <td style="font-weight:bold;"><?= $model->user->program->required_hours." hrs " ?></td>
            </tr>
            

            <tr>
                <td>TOTAL HOURS RENDERED</td>
                <td style="font-weight:bold;"><?= $totalOverall. " hr/s " ?> </td> 
                <!-- .$overAllTotal." min/s " -->
            </tr>
            <tr>
                <td>TOTAL HOURS REMAINED</td>
                <td style="font-weight:bold;"><?php 
                $totalWithDecimal = $model->user->program->required_hours - $totalOverall;
                echo $totalWithDecimal." hr/s ";
                ?></td>
            </tr>
        </tbody>
    </table>
    </div>
    <?php } ?>

</div>
