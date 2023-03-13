<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProgramMajor $model */

$this->title = 'Create Program Major';
$this->params['breadcrumbs'][] = ['label' => 'Program Majors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="program-major-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'program' => $program,
    ]) ?>

</div>
