<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserData $model */

$this->title = 'Create User Account';
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index','UserDataSearch[item_name]' => 'Trainee']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-data-create">

    <h1> 
        <?php
            switch ($account_type) {
                case 'trainee':
                    echo "Create Trainee";
                break;
                case 'ojtcoordinator':
                    echo "Create OJT Coordinator";
                break;
                case 'companysupervisor':
                    echo "Create Company Supervisor";
                break;
                case 'administrator':
                    echo "Create Administrator";
                break;
                
                default:
                    # code...
                break;
            }
        ?>
    </h1>

    <?= $this->render('_form', [
        'model' => $model,
        'account_type' => $account_type,
        'roleArr' => $roleArr,
        'suffix' => $suffix,
        'student_section' => $student_section,
        'student_year' => $student_year,
        'program' => $program,
        'position' => $position,
        'department' => $department,
        'company' => $company,
    ]) ?>

</div>
