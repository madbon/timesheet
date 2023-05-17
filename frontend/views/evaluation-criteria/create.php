<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EvaluationCriteria $model */

$this->title = 'Create Evaluation Criteria';
$this->params['breadcrumbs'][] = ['label' => 'Evaluation Criterias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evaluation-criteria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
