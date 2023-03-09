<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CmsRoleAssignment $model */

$this->title = 'Create Cms Role Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Cms Role Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-role-assignment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
