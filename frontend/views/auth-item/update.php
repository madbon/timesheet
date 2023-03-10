<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AuthItem $model */

if($model->type == 1)
{
    $this->title = 'Update Role: ' . $model->name;
    $this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['roles']];
    // $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'name' => $model->name]];
    $this->params['breadcrumbs'][] = 'Update';
}
else
{
    $this->title = 'Update Permission: ' . $model->name;
    $this->params['breadcrumbs'][] = ['label' => 'Permissions', 'url' => ['permissions']];
    // $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'name' => $model->name]];
    $this->params['breadcrumbs'][] = 'Update';
}

?>
<div class="auth-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
