<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StudentYear $model */

$this->title = 'Create Student Year';
$this->params['breadcrumbs'][] = ['label' => 'Student Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-year-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
