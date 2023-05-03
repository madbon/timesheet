<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\DocumentType $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Task Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="document-type-view">

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
            'id',
            'title',
            'action_title',
            [
                'label' => 'Required Uploading of Files?',
                'value' => function($model)
                {
                    return $model->required_uploading ? "YES" : "NO";
                }
            ],
            [
                'label' => 'Required Remarks?',
                'value' => function($model)
                {
                    return $model->required_remarks ? "YES" : "NO";
                }
            ],
            [
                'label' => 'Enabled Tagging?',
                'value' => function($model)
                {
                    return $model->enable_tagging ? "YES" : "NO";
                }
            ],
            [
                'label' => 'Enabled Commenting?',
                'value' => function($model)
                {
                    return $model->enable_commenting ? "YES" : "NO";
                }
            ],
        ],
    ]) ?>

</div>
