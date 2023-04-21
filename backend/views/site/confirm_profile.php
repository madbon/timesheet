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
                        echo Html::a('<strong><i class="fas fa-arrow-left"></i> BACK</strong>',['/facial-recognition','timesheet_id' => $timesheet_id],['class' => 'btn btn-outline-danger btn-lg', 'style' => 'border-radius:25px;']);
                    ?>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top:50px;">
        <h1 class="display-4" style="font-weight:bold;">IS THIS YOU?</h1>
        <p class="lead">Please click the buttons below to confirm.</p>
    </div>

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
</div>


