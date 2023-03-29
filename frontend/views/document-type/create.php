<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DocumentType $model */

$this->title = 'Create Task Type';
$this->params['breadcrumbs'][] = ['label' => 'Task Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
