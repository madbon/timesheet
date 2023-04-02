<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CoordinatorPrograms $model */

$this->title = 'Assign Program to OJT Coordinator';
$this->params['breadcrumbs'][] = ['label' => 'Coordinator Programs/Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coordinator-programs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user_id' => $user_id,
    ]) ?>

</div>
