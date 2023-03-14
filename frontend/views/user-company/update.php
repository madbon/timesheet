<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserCompany $model */

$this->title = 'Update User Company: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-company-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
