<?php
use yii\helpers\Html;
use yii\web\View;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<style>

table.time-details tbody tr td
{
    text-align: center;
    text-transform: uppercase;
}


table.time-details tbody tr:nth-child(1) td,table.time-details tbody tr:nth-child(2) td
{
    font-weight: bold;
}

table.student-details tbody tr td:nth-child(2)
{
    text-transform: uppercase;
}

table.student-details tbody tr td:nth-child(1)
{
    font-weight: bold;
}
table.student-details tbody tr td
{
    font-size: 13px;
}
</style>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent" style="padding-top:20px;">
        <div class="row">
            <div class="col-sm-12" style="text-align: left;">
                    <?php 
                        echo Html::a('<strong><i class="fas fa-arrow-left"></i> TRY AGAIN</strong>',['/facial-recognition','timesheet_id' => $timesheet_id],['class' => 'btn btn-outline-danger btn-lg', 'style' => 'border-radius:25px;']);
                    ?>
            </div>
        </div>
    </div>

    
    <div style="text-align: center;">
        <h1 class="display-4" style="font-weight:bold; font-size:30px;">IS THIS YOU?</h1>
        <center>
            <div style="height:150px; width:200px; text-align:center;">
                <?php
                    $uploadedFile = Yii::$app->getModule('admin')->GetFacialRegister('UserFacialRegister',$user_id);

                    $filePath = Yii::$app->request->baseUrl.'/uploads/' . $uploadedFile;

                    // print_r($filePath); exit;

                    if($filePath) 
                    {
                        echo Html::img($filePath, ['alt'=>'My Image', 'style' => 'width:100%; height:100%;', 'class' => 'img-responsive']);
                    }
                    else
                    {
                        // echo "--NO PROFILE PHOTO--";
                    }
                ?>
            </div>
        </center>
        <p class="lead">
        <?php if($user_status == 10){ ?>
        Please click the buttons below to confirm.
        <?php }else{ echo "Your account has been DEACTIVATED. Please contact the System Administrator. Thank you."; } ?>
        </p>
    </div>

    <?php if($user_status == 10){ ?>
    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">

                <p class="lead" style="font-weight:bold;">STUDENT DETAILS</p>
                <table class="table table-bordered student-details">
                    <tbody>
                        <tr>
                            <td colspan="2">STUDENT NO. </td>
                            <td colspan="2" style="font-weight:bold; font-size:20px;"><?= !empty($model->user->student_idno) ? $model->user->student_idno : "" ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">NAME</td>
                            <td colspan="2" style="font-weight:bold; font-size:25px;"><?= !empty($model->user->userFullName) ? $model->user->userFullName : "" ?></td>
                        </tr>
                        <tr>
                            <td>PROGRAM/COURSE</td>
                            <td colspan="2">
                                <?= !empty($model->user->program->title) ? $model->user->program->title : "" ?>
                                <?= !empty($model->user->programMajor->title) ? " Major in ".$model->user->programMajor->title : "" ?>
                            </td>
                        </tr>
                        <tr>
                            <td>COMPANY</td>
                            <td colspan="2">
                                <?= !empty($model->user->userCompany->company->name) ? $model->user->userCompany->company->name : "" ?>
                            </td>
                        </tr>
                        <tr>
                            <td>COMPANY ADDRESS</td>
                            <td colspan="2">
                                <?= !empty($model->user->userCompany->company->address) ? $model->user->userCompany->company->address : "" ?>
                            </td>
                        </tr>
                        <tr>
                            <td>ASSIGNED DEPARTMENT</td>
                            <td colspan="2">
                                <?= !empty($model->user->department->title) ? $model->user->department->title : "" ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                
            </div>
           
        </div>

        <div class="jumbotron text-center bg-transparent" style="padding-top:20px;">
            <div class="row">
                <div class="col-sm-6" style="text-align: left;">
                        <?php 
                            echo Html::a('<strong style="font-size:25px;"><i class="fas fa-user-times"></i> NO, THIS IS NOT ME.</strong> <br/>I would prefer to time in/out with my Login Credentials.',['/capture-login-no-facial-recog','timesheet_id' => $timesheet_id],['class' => 'btn btn-warning btn-lg', 'style' => 'border-radius:25px;']);
                        ?>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                        <?php 
                            echo Html::a('<strong style="font-size:25px;"><i class="fas fa-user-check"></i> YES, THIS IS ME</strong>',['/confirm-profile-success','user_id' => $user_id, 'timesheet_id' => $timesheet_id],['class' => 'btn btn-success btn-lg', 'style' => 'border-radius:25px;']);
                        ?>
                </div>
            </div>
        </div>

    </div>
    <?php } ?>
</div>


