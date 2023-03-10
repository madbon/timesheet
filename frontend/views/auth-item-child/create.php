<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AuthItemChild $model */

$this->title = 'Assign Permission to Role';
$this->params['breadcrumbs'][] = ['label' => "Role Assignments", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roleArr' => $roleArr,
        'permissionsArr' => $permissionsArr,
    ]) ?>

</div>
