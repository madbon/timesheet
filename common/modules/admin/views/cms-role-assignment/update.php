<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CmsRoleAssignment $model */

$this->title = 'Update Cms Role Assignment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cms Role Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-role-assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
