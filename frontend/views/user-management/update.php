<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserData $model */

$this->title = 'Update User Account: ' . $model->fullName();
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "Account Details: ".$model->fullName(), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        $account_type =NULL;
        switch ($model->authAssignment->item_name) {
            case 'Trainee':
               $account_type = "trainee";
            break;
            case 'OjtCoordinator':
                $account_type = "ojtcoordinator";
            break;
            case 'CompanySupervisor':
                $account_type = "companysupervisor";
            break;
            case 'Administrator':
                $account_type = "administrator";
            break;
            
            default:
                # code...
            break;
        }
    ?>

    <?= $this->render('_form', [
        'model' => $model,
        'roleArr' => $roleArr,
        'suffix' => $suffix,
        'student_section' => $student_section,
        'student_year' => $student_year,
        'program' => $program,
        'major' => $major,
        'account_type' => $account_type,
    ]) ?>

</div>
