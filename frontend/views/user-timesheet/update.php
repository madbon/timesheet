<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserTimesheet $model */

$this->title = 'Update User Timesheet: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Timesheets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-timesheet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
