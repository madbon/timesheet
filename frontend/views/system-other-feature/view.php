<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\SystemOtherFeature $model */

$this->title = $model->feature;
$this->params['breadcrumbs'][] = ['label' => 'System Other Features', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="system-other-feature-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            // 'id',
            'feature',
            // 'enabled',
            [
                'attribute' => 'enabled',
                'value' => function($model)
                {
                    return $model->enabled ? "YES" : "NO";
                },
                'filter' => [1 => 'YES', 0 => 'NO'],
            ],
        ],
    ]) ?>

</div>
