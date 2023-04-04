<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Announcement $model */

// $this->title = 'Create Announcement';
// $this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="announcement-create">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
