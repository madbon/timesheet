<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserTimesheet $model */

$this->title = 'Update Remarks: ' . (!empty($model->date) ? date('F j, Y', strtotime($model->date)) : date('F j, Y', strtotime($date)));
$this->params['breadcrumbs'][] = ['label' => 'Timesheets', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-timesheet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user_id' => $user_id,
        'date' => $date,
    ]) ?>

</div>
