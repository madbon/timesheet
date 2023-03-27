<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SubmissionThread $model */

$this->title = 'Create Transaction';
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="submission-thread-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'documentType' => $documentType,
        'modelUpload' => $modelUpload,
    ]) ?>

</div>
