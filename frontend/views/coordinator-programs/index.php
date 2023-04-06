<?php

use common\models\CoordinatorPrograms;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\CoordinatorProgramsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Coordinator Programs/Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coordinator-programs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Assign Program to OJT Coordinator', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\RefProgram::find()->all(), 'id', 'title'),
            ],
            // 'ref_program_major_id',
            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}',
                'urlCreator' => function ($action, CoordinatorPrograms $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
