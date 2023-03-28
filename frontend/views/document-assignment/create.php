<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DocumentAssignment $model */

$this->title = 'Create Document Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Document Assignments', 'url' => ['index']];
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
