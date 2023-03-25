<?php
use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<style>

table.time-details tbody tr td
{
    text-align: center;
    text-transform: uppercase;
}

table.time-details tbody tr:nth-child(3) td
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
        <h1 class="display-4">SUCCESS!</h1>

        <p class="lead">You have successfully recorded your time in/out. You can check it below.</p>
        <div style="text-align: center;">
                    <?php 
                //     echo Html::beginForm(['/site/logout'], 'post', ['class' => ''])
                // . Html::submitButton(
                //     'BACK TO TIME IN/OUT PORTAL',
                //     ['class' => 'btn btn-outline-primary btn-lg', 'style' => 'text-align:center']
                // )
                // . Html::endForm(); 
                echo Html::a('Back to Portal',['/site/backtoportal']);
                ?>
                </div>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <p class="lead" style="font-weight:bold;">TIME IN/OUT DETAILS: <span style="text-align: right; font-weight:normal;"><?= !empty($model->date) ? date('F j, Y',strtotime($model->date)) : "" ?></span></p>
                <table class="table table-bordered time-details">
                    <tbody>
                        <tr>
                            <td colspan="2">AM</td>
                            <td colspan="2">PM</td>
                        </tr>
                        <tr>
                            <td>TIME IN</td>
                            <td>TIME OUT</td>
                            <td>TIME IN</td>
                            <td>TIME OUT</td>
                        </tr>
                        <tr>
                            <td><?= !empty($time_in_am) ? date('g:i:s A', strtotime($time_in_am)) : ""; ?></td>
                            <td><?= !empty($time_out_am) ? date('g:i:s A', strtotime($time_out_am)) : ""; ?></td>
                            <td><?= !empty($time_in_pm) ? date('g:i:s A', strtotime($time_in_pm)) : ""; ?></td>
                            <td><?= !empty($time_out_pm) ? date('g:i:s A', strtotime($time_out_pm)) : ""; ?></td>
                        </tr>
                    </tbody>
                </table>

                <p class="lead" style="font-weight:bold;">STUDENT DETAILS</p>
                <table class="table table-bordered student-details">
                    <tbody>
                        <tr>
                            <td colspan="2">STUDENT NO. </td>
                            <td colspan="2"><?= !empty($model->user->student_idno) ? $model->user->student_idno : "" ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">NAME</td>
                            <td colspan="2"><?= !empty($model->user->userFullName) ? $model->user->userFullName : "" ?></td>
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

    </div>
</div>
