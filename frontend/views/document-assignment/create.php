<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DocumentAssignment $model */

$this->title = 'Create Task Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Task Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-assignment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authItem' => $authItem,
        'documentType' => $documentType,
    ]) ?>

</div>
