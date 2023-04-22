<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SystemOtherFeature $model */

$this->title = 'Update System Other Feature: ' . $model->feature;
$this->params['breadcrumbs'][] = ['label' => 'System Other Features', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->feature, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="system-other-feature-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
