<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserData $model */

$this->title = 'Create User Account';
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-data-create">

    <h1> 
        <?php
            switch ($account_type) {
                case 'trainee':
                    echo 'Create Trainee';
                break;
                
                default:
                    # code...
                break;
            }
        ?>
    </h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roleArr' => $roleArr,
        'suffix' => $suffix,
        'student_section' => $student_section,
        'student_year' => $student_year,
        'program' => $program,
    ]) ?>

</div>
