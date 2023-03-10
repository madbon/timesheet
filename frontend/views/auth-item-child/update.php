<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AuthItemChild $model */

$this->title = 'Update Assigned Permission: ' . $model->parent;
$this->params['breadcrumbs'][] = ['label' => 'Role Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->parent, 'url' => ['view', 'parent' => $model->parent, 'child' => $model->child]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auth-item-child-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roleArr' => $roleArr,
        'permissionsArr' => $permissionsArr,
        'child' => $child,
    ]) ?>

</div>
