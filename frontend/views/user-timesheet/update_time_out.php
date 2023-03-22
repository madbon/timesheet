<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserTimesheet $model */

$this->title = 'Update Time In/Out: ' . date('F j, Y', strtotime($model->date));
$this->params['breadcrumbs'][] = ['label' => 'Timesheets', 'url' => ['index','trainee_user_id' => $model->user->id]];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-timesheet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update_timeout', [
        'model' => $model,
    ]) ?>

</div>
