<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Suffix $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Suffixes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="suffix-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'title' => $model->title], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'title' => $model->title], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'meaning',
        ],
    ]) ?>

</div>
