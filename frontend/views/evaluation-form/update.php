<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EvaluationForm $model */

$this->title = $model->evaluationCriteria->title;
$this->params['breadcrumbs'][] = ['label' => 'Evaluation Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evaluation-form-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
