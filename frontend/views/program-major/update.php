<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProgramMajor $model */

$this->title = 'Update Program Major: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Program Majors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="program-major-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'program' => $program,
    ]) ?>

</div>
