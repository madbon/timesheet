<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Suffix $model */

$this->title = 'Update Suffix: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Suffixes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'title' => $model->title]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="suffix-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
