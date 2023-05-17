<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EvaluationForm $model */

$this->title = 'Create Evaluation Form';
$this->params['breadcrumbs'][] = ['label' => 'Evaluation Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evaluation-form-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
