<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SubmissionThread $model */

if($from_eval_form)
{
    $this->title = 'Submit Evaluation Form: '.$traineeName;
    $this->params['breadcrumbs'][] = ['label' => 'Evaluation Forms', 'url' => ['/user-management/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Evaluation Form: '.$traineeName, 'url' => ['/evaluation-form/index', 'trainee_user_id' => $trainee_user_id]];
    $this->params['breadcrumbs'][] = $this->title;
}
else
{
    $this->title = "";
    $this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="submission-thread-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'documentType' => $documentType,
        'modelUpload' => $modelUpload,
        'trainee_user_id' => $trainee_user_id,
        'from_eval_form' => $from_eval_form,
    ]) ?>

</div>
