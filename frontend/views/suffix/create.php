<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Suffix $model */

$this->title = 'Create Suffix';
$this->params['breadcrumbs'][] = ['label' => 'Suffixes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suffix-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
