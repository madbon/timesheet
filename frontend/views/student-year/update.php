<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StudentYear $model */

$this->title = 'Update Student Year: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Student Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'year' => $model->year]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-year-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
