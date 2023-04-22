<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserArchive $model */

$this->title = 'Create User Archive';
$this->params['breadcrumbs'][] = ['label' => 'User Archives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-archive-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
