<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\CoordinatorPrograms $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Coordinator Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="coordinator-programs-view">

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
            [
                'attribute' => 'user_id',
                'value' => function($model)
                {
                    return !empty($model->user->userFullName) ? $model->user->userFullName : "";
                },
                // 'filter' => \yii\helpers\ArrayHelper::map(\common\models\DocumentType::find()->all(), 'id', 'title'),
            ],
            [
                'attribute' => 'ref_program_id',
                'value' => function($model)
                {
                    $program = !empty( $model->program->title) ?  $model->program->title : "";
                    $abbre =  !empty($model->program->abbreviation) ? " [".$model->program->abbreviation."]" : "";
                    return $program.$abbre;
                }
            ],
            // 'ref_program_major_id',
        ],
    ]) ?>

</div>
