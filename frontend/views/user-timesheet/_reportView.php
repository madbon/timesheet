<?php
use yii\helpers\Html;
use common\models\UserTimesheet;
?>

<table class="table-primary-details">
    <tbody>
        <tr>
            <td style="font-weight:bold; font-size:11px; ">NAME:</td>
            <td colspan="3" style="font-size:11px; border-bottom:2px solid black; font-weight:bold; text-transform:uppercase;"><?= $model->user->userFullName; ?></td>
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
                    <th style='border-left:1px solid white; border-top:1px solid white;'></th>
                    <th colspan='2'>AM</th>
                    <th colspan='2'>PM</th>
                    <th colspan='4' style='border-top:1px solid white; border-right:1px solid white;'></th>
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

            foreach ($date_range as $date) {
                $models = UserTimesheet::findAll(['date' => $date->format('Y-m-d'), 'user_id' => Yii::$app->user->identity->id]); // Retrieve all models for date

                

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
                            echo "<td></td>";
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
            <td style="display: flex; justify-content: center; align-items: center; text-align:center;">
                <?php
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