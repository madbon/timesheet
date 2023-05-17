<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EvaluationCriteria $model */

$this->title = 'Update Evaluation Criteria: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Evaluation Criterias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evaluation-criteria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
