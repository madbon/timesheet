<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CmsRole $model */

$this->title = 'Update Cms Role: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cms Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-role-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
