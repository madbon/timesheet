<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CoordinatorPrograms $model */

$this->title = 'Update Coordinator Programs/Courses';
$this->params['breadcrumbs'][] = ['label' => 'Coordinator Programs/Courses', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="coordinator-programs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user_id' => $model->user_id,
    ]) ?>

</div>
