<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DocumentAssignment $model */

$this->title = 'Update Document Assignment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Document Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authItem' => $authItem,
        'documentType' => $documentType,
    ]) ?>

</div>
