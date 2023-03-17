<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserTimesheet $model */

$this->title = 'Create User Timesheet';
$this->params['breadcrumbs'][] = ['label' => 'User Timesheets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-timesheet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
