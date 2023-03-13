<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\RefProgram $model */

$this->title = 'Update Program/Course: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Programs/Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-program-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
