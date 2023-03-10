<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AuthItem $model */

$this->title = 'Create Permission';
$this->params['breadcrumbs'][] = ['label' => 'Permissions', 'url' => ['permissions']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
