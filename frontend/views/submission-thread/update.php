<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SubmissionThread $model */

$this->title = 'Update: '.$model->documentType->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Details', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="submission-thread-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'documentType' => $documentType,
        'modelUpload' => $modelUpload,
    ]) ?>

</div>
