<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CmsRoleActions $model */

$this->title = 'Update Cms Role Actions: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cms Role Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-role-actions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
