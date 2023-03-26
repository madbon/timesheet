<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SubmissionReply $model */

$this->title = 'Create Submission Reply';
$this->params['breadcrumbs'][] = ['label' => 'Submission Replies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="submission-reply-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
