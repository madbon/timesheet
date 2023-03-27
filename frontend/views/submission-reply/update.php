<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SubmissionReply $model */

$this->title = 'Update Submission Reply: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Submission Replies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="submission-reply-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
