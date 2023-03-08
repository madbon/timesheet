<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserData $model */

$this->title = 'Update User Account: ' . $model->fullName();
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "Account Details: ".$model->fullName(), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
