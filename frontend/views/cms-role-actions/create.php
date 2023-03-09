<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CmsRoleActions $model */

$this->title = 'Create Cms Role Actions';
$this->params['breadcrumbs'][] = ['label' => 'Cms Role Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-role-actions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
