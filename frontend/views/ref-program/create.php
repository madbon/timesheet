<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\RefProgram $model */

$this->title = 'Create Program/Course';
$this->params['breadcrumbs'][] = ['label' => 'Programs/Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-program-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
