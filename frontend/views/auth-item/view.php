<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\AuthItem $model */

if($model->type == 1)
{
    $this->title = $model->name;
    $this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['roles']];
    $this->params['breadcrumbs'][] = $this->title;
}
else
{
    $this->title = $model->name;
    $this->params['breadcrumbs'][] = ['label' => 'Permissions', 'url' => ['permissions']];
    $this->params['breadcrumbs'][] = $this->title;
}

\yii\web\YiiAsset::register($this);
?>
<div class="auth-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'name' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'name' => $model->name], [
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
            'name',
            // 'type',
            'description:ntext',
            // 'rule_name',
            // 'data',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
