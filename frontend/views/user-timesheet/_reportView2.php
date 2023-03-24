<?php
use yii\helpers\Html;
use common\models\UserTimesheet;
?>

<h1 style="text-align: center; font-size:20px; font-weight:bold;">DAILY TIME RECORD</h1>
<table class="table-primary-details">
    <tbody>
        <tr>
            <td style="font-weight:bold; font-size:11px; ">NAME:</td>
            <td colspan="3" style="font-size:11px; border-bottom:2px solid black; font-weight:bold; text-transform:uppercase;"><?= $model->user->userFullNameWithMiddleInitial; ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold; font-size:11px;">MONTH:</td>
            <td colspan="3" style="font-size:11px; border-bottom:2px solid black; font-weight:bold;"><?= $month ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;">OFFICE HOUR:</td>
            <td style="color:red;font-size:11px;">IN: 8:00AM <br/>OUT: 12:00PM</td>
            <td style="color:red;font-size:11px;" colspan="2">IN: 1:00PM <br/>OUT: 05:00PM</td>
        </tr>
    </tbody>
</table>

<?php  ?>

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
                    <th colspan='4' style='border-top:1px solid #f5f6ff; border-right:1px solid #f5f6ff; background:#f5f6ff;'></th>
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
                            $end_time->modify('-1 hour');

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
            echo "</tr>";

            echo "</tbody>";
            echo "</table>";
        ?>

<!-- SIGNATURE -->
<table>
    <tbody>
        <tr>
            <td style="display: flex; justify-content: center; align-items: center; text-align:center;">
                <?php
                    $uploadedFileName = Yii::$app->getModule('admin')->GetFileNameExt('UserData',$model->user->id);

                    $uploadedFile = Yii::$app->getModule('admin')->GetFileUpload('UserData',$model->user->id);
        
                    if(Yii::$app->getModule('admin')->FileExists($uploadedFileName)) 
                    {
                        echo Html::img(Yii::$app->request->baseUrl.$uploadedFile, ['alt'=>'My Image', 'style' => '', 'height' => '70', 'width' => '70']);
                    }
                    else
                    {
                        echo "NO UPLOADED E-SIGNATURE";
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid black; text-align:center; font-size:11px; "><?= !empty($model->user->UserFullNameWithMiddleInitial) ? $model->user->UserFullNameWithMiddleInitial : "" ?></td>
        </tr>
        <tr>
            <td style="font-size:11px; font-weight:bold; text-align:center;">Intern Signature over printed name</td>
        </tr>
        <tr>
            <td style="display: flex; justify-content: center; align-items: center; text-align:center; height:50px;">
                <?php
                    if(empty($countPendingRecord))
                    {
                        $uploadedFileNameCP = Yii::$app->getModule('admin')->GetFileNameExt('UserData',$model->user->id);

                        $uploadedFileCP = Yii::$app->getModule('admin')->GetFileUpload('UserData',Yii::$app->getModule('admin')->GetSupervisorIdByTraineeUserId($model->user_id));
            
                        if(Yii::$app->getModule('admin')->FileExists($uploadedFileNameCP)) 
                        {
                            echo Html::img(Yii::$app->request->baseUrl.$uploadedFileCP, ['alt'=>'My Image', 'style' => '', 'height' => '50', 'width' => '50']);
                        }
                        else
                        {
                            echo "NO UPLOADED E-SIGNATURE";
                        }
                    }
                    
                ?>
            </td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid black; text-align:center; font-weight:bold; text-transform:uppercase; font-size:11px;"><?= Yii::$app->getModule('admin')->GetSupervisorByTraineeUserId($model->user_id); ?></td>
        </tr>
        <tr>
            <td style="font-size:11px; font-weight:bold;">Immidiate Supervisor Signature over printed name</td>
        </tr>
    </tbody>
</table>