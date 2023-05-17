<?php
    use yii\helpers\Html;
?>

<?= Html::img(Yii::$app->request->baseUrl.'/ref/images/eval_header.png', ['alt'=>'']) ?>

<h3 style="text-align:center; font-size:18px; font-weight:bold;">EVALUATION FORM</h3>
<p style="font-weight:bold;">Part I (to be filled up by the trainee)</p>
<table>
    <tbody>
        <tr>
            <td style="font-weight: bold;">Name:</td>
            <td style="border-bottom:1px solid black; width:250px;"><?= !empty($user->userFullNameWithMiddleInitial) ? $user->userFullNameWithMiddleInitial : "" ?></td>
            <td style="font-weight: bold;">Age:</td>
            <td style="border-bottom:1px solid black; width:50px;"><?= Yii::$app->getModule('admin')->calculateAge($user->bday) ?></td>

            <td style="font-weight: bold;">Gender:</td>
            <td style="border:1px solid black; width:25px; text-align:center;"> <?= $user->sex == "F" ? 'X' : '' ?> </td>
            <td style="font-weight: bold;">Female</td>
            <td style="border:1px solid black; width:25px; text-align:center;"><?= $user->sex == "M" ? 'X' : '' ?></td>
            <td style="font-weight: bold;">Male</td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td style="font-weight: bold;">Course:</td>
            <td  style="border-bottom:1px solid black; width:510px;"><?= !empty($user->program->title) ? $user->program->title : '' ?></td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td style="font-weight: bold;">Major:</td>
            <td style="border-bottom:1px solid black; width:280px;"><?= !empty($user->programMajor->title) ? $user->programMajor->title : '' ?></td>
            <td style="font-weight: bold;">Contact Number:</td>
            <td style="border-bottom:1px solid black; width:150px;"><?= $user->mobile_no ?></td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td style="font-weight: bold;">Permanent Address:</td>
            <td style="border-bottom:1px solid black; width:448px;"><?= $user->address ?></td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td style="font-weight: bold;">Company Assigned:</td>
            <td style="border-bottom:1px solid black; width:450px;"><?= !empty($user->userCompany->company->name) ?  $user->userCompany->company->name : ''  ?></td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td style="font-weight: bold;">Number of Training Hours:</td>
            <td style="border:1px solid black; width:25px; text-align:center;">
            <?php 
                if(!empty($user->program->required_hours))
                {
                    if($user->program->required_hours == '162')
                    {
                        echo 'X';
                    }
                }
            ?>
            </td>
            <td style="font-weight: bold;">162</td>

            <td style="border:1px solid black; width:25px; text-align:center;">
            <?php 
                if(!empty($user->program->required_hours))
                {
                    if($user->program->required_hours == '324')
                    {
                        echo 'X';
                    }
                }
            ?>
            </td>
            <td style="font-weight: bold;">324</td>

            <td style="border:1px solid black; width:25px; text-align:center;">
            <?php 
                if(!empty($user->program->required_hours))
                {
                    if($user->program->required_hours == '486')
                    {
                        echo 'X';
                    }
                }
            ?>
            </td>
            <td style="font-weight: bold;">486</td>
        </tr>
    </tbody>
</table>

<table style="margin-left:350px;">
    <tbody>
        <tr>
            <td style="border-bottom:1px solid black; width:170px; text-align:center;">
                <?php
                    $uploadedFileNameCP = Yii::$app->getModule('admin')->GetFileNameExt('UserData',$user->id);

                    $uploadedFileCP = Yii::$app->getModule('admin')->GetFileUpload('UserData',$user->id);
        
                    if(Yii::$app->getModule('admin')->FileExists($uploadedFileNameCP)) 
                    {
                        echo Html::img(Yii::$app->request->baseUrl.$uploadedFileCP, ['alt'=>'Signature', 'style' => '', 'height' => '50', 'width' => '50']);
                    }
                    else
                    {
                        echo "NO UPLOADED E-SIGNATURE";
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight:bold;">Signature of Trainee</td>
        </tr>
    </tbody>
</table>

<p style="font-weight:bold; margin-top:20px;">Part II (to be filled up by the company representative)</p>

<p style="font-weight: bold;">Inclusive date for this Evaluation:</p>
<table>
    <tbody>
        <tr>
            <td style="font-weight: bold;">Date Commenced:</td>
            <td style="border-bottom:1px solid black; width:150px; text-align:center;"> <?= !empty($subThreadOne->date_commenced) ? date('F j, Y',strtotime($subThreadOne->date_commenced)) : '' ?></td>
            <td style="width:50px;"></td>
            <td style="font-weight: bold;">Date Completed:</td>
            <td style="border-bottom:1px solid black; width:150px; text-align:center;"> <?= !empty($subThreadOne->date_completed) ? date('F j, Y',strtotime($subThreadOne->date_completed)) : '' ?></td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered" style="margin-top:10px;">
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
                <td style="font-weight: bold;"><?= $eval->evaluationCriteria->title ?></td>
                <td style="font-weight: bold;"><?= $eval->evaluationCriteria->max_points ?></td>
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
<table>
    <tbody>
        <tr>
            <td></td>
            <td style="text-align:center;">
            <?php
                    $uploadedFileNameCP = Yii::$app->getModule('admin')->GetFileNameExt('UserData',Yii::$app->getModule('admin')->GetSupervisorIdByTraineeUserId($user->id));

                    $uploadedFileCP = Yii::$app->getModule('admin')->GetFileUpload('UserData',Yii::$app->getModule('admin')->GetSupervisorIdByTraineeUserId($user->id));
        
                    if(Yii::$app->getModule('admin')->FileExists($uploadedFileNameCP)) 
                    {
                        echo Html::img(Yii::$app->request->baseUrl.$uploadedFileCP, ['alt'=>'Signature', 'style' => '', 'height' => '50', 'width' => '50']);
                    }
                    else
                    {
                        echo "NO UPLOADED E-SIGNATURE";
                    }
                ?>
            </td>
            <td></td>
            <td></td>
            <td style="text-align:center;">
                <?php
                    $uploadedFileNameCP = Yii::$app->getModule('admin')->GetFileNameExt('UserData',Yii::$app->getModule('admin')->GetSupervisorIdByTraineeUserId($user->id));

                    $uploadedFileCP = Yii::$app->getModule('admin')->GetFileUpload('UserData',Yii::$app->getModule('admin')->GetSupervisorIdByTraineeUserId($user->id));
        
                    if(Yii::$app->getModule('admin')->FileExists($uploadedFileNameCP)) 
                    {
                        echo Html::img(Yii::$app->request->baseUrl.$uploadedFileCP, ['alt'=>'Signature', 'style' => '', 'height' => '50', 'width' => '50']);
                    }
                    else
                    {
                        echo "NO UPLOADED E-SIGNATURE";
                    }
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Evaluated By:</td>
            <td style="border-bottom:1px solid black; width:200px; text-align:center;">
                <?= Yii::$app->getModule('admin')->GetSupervisorByTraineeUserId($user->id); ?>
            </td>
            <td style="width:30px;"></td>
            <td style="font-weight: bold;">Approved By:</td>
            <td style="border-bottom:1px solid black; width:200px; text-align:center;">
            <?= Yii::$app->getModule('admin')->GetSupervisorByTraineeUserId($user->id); ?>
            </td>
        </tr>
        <tr>
            <td>
                
            </td>
            <td style="text-align: center; font-style:italic; font-weight:bold;">(Signature over printed name)</td>
            <td></td>
            <td></td>
            <td style="text-align: center; font-style:italic; font-weight:bold;">(Signature over printed name)</td>
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
            <td style="font-weight: bold;">Designation:</td>
            <td style="border-bottom:1px solid black; width:200px; text-align:center;"><?= Yii::$app->getModule('admin')->GetSupervisorPositionByTraineeUserId($user->id); ?></td>
            <td style="width:30px;"></td>
            <td style="font-weight: bold;">Designation:</td>
            <td style="border-bottom:1px solid black; width:200px; text-align:center;"><?= Yii::$app->getModule('admin')->GetSupervisorPositionByTraineeUserId($user->id); ?></td>
        </tr>
    </tbody>
</table>
</div>

<?= Html::img(Yii::$app->request->baseUrl.'/ref/images/footer_1.png', ['alt'=>'', 'style' => 'margin-top:20px;']) ?>
<?= Html::img(Yii::$app->request->baseUrl.'/ref/images/footer_2.png', ['alt'=>'', 'style' => 'margin-top:10px;']) ?>