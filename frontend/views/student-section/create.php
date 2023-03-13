<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StudentSection $model */

$this->title = 'Create Student Section';
$this->params['breadcrumbs'][] = ['label' => 'Student Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-section-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
