<?php
    use yii\helpers\Html;
?>

<?= Html::img(Yii::$app->request->baseUrl.'/ref/images/eval_header.png', ['alt'=>'']) ?>

<h3 style="text-align:center; font-size:18px; font-weight:bold;">EVALUATION FORM</h3>
<p style="font-weight:bold;">Part I (to be filled up by the trainee)</p>
<table>
    <tbody>
        <tr>
            <td>Name:</td>
            <td style="border-bottom:1px solid black; width:250px;"></td>
            <td>Age:</td>
            <td style="border-bottom:1px solid black; width:50px;"></td>

            <td>Gender:</td>
            <td style="border:1px solid black; width:25px;"></td>
            <td>Female</td>
            <td style="border:1px solid black; width:25px;"></td>
            <td>Male</td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td>Course:</td>
            <td  style="border-bottom:1px solid black; width:510px;"></td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td>Major:</td>
            <td style="border-bottom:1px solid black; width:280px;"></td>
            <td>Contact Number:</td>
            <td style="border-bottom:1px solid black; width:150px;"></td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td>Permanent Address:</td>
            <td style="border-bottom:1px solid black; width:448px;"></td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td>Company Assigned:</td>
            <td style="border-bottom:1px solid black; width:450px;"></td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td>Number of Training Hours:</td>
            <td style="border:1px solid black; width:25px;"></td>
            <td>162</td>

            <td style="border:1px solid black; width:25px;"></td>
            <td>324</td>

            <td style="border:1px solid black; width:25px;"></td>
            <td>486</td>
        </tr>
    </tbody>
</table>

<table style="margin-top:20px; margin-left:350px;">
    <tbody>
        <tr>
            <td style="border-bottom:1px solid black; width:170px;"></td>
        </tr>
        <tr>
            <td style="text-align: center;">Signature of Trainee</td>
        </tr>
    </tbody>
</table>

<p style="font-weight:bold; margin-top:20px;">Part II (to be filled up by the company representative)</p>

<p style="font-weight: bold;">Inclusive date for this Evaluation:</p>
<table>
    <tbody>
        <tr>
            <td>Date Commenced:</td>
            <td style="border-bottom:1px solid black; width:150px;"></td>
            <td style="width:50px;"></td>
            <td>Date Completed:</td>
            <td style="border-bottom:1px solid black; width:150px;"></td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered" style="margin-top:30px;">
    <thead>
        <tr>
            <th>Criteria</th>
            <th>Max Points</th>
            <th>Points Scored</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <?php 
       
        $totalPoints = 0;
        foreach ($query as $eval) { 
            $totalPoints += $eval->points_scored;
            ?>
            <tr>
                <td><?= $eval->evaluationCriteria->title ?></td>
                <td><?= $eval->evaluationCriteria->max_points ?></td>
                <td><?= $eval->points_scored ?></td>
                <td><?= $eval->remarks ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td style="text-align: right; padding-right:10px; font-weight:bold;">TOTAL</td>
            <td style="font-weight: bold;">100</td>
            <td style="font-weight: bold;"><?= $totalPoints ?></td>
            <td></td>
        </tr>
    </tbody>
</table>

<p style="font-weight: bold;">Comments/Recommendations for the trainee’s further growth:</p>
<p style="font-style: italic; text-indent:40px;"><?= $subThreadOne->remarks ?></p>

<div style="margin-left:50px; margin-right:50px;">
<table style="margin-top:20px;">
    <tbody>
        <tr>
            <td>Evaluated By:</td>
            <td style="border-bottom:1px solid black; width:200px;"></td>
            <td style="width:30px;"></td>
            <td>Approved By:</td>
            <td style="border-bottom:1px solid black; width:200px;"></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center; font-style:italic;">(Signature over printed name)</td>
            <td></td>
            <td></td>
            <td style="text-align: center; font-style:italic;">(Signature over printed name)</td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Designation:</td>
            <td style="border-bottom:1px solid black; width:200px;"></td>
            <td style="width:30px;"></td>
            <td>Designation:</td>
            <td style="border-bottom:1px solid black; width:200px;"></td>
        </tr>
    </tbody>
</table>
</div>

<?= Html::img(Yii::$app->request->baseUrl.'/ref/images/footer.png', ['alt'=>'', 'style' => 'margin-top:50px;']) ?>