<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Announcement $model */

$this->title = 'Update Announcement ';
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="announcement-update">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'modelUpload' => $modelUpload,
    ]) ?>

</div>
