<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CmsRole $model */

$this->title = 'Create Cms Role';
$this->params['breadcrumbs'][] = ['label' => 'Cms Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
