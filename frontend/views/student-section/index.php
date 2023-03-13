<?php

use common\models\StudentSection;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\StudentSectionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Student Sections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-section-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Student Section', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'section',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, StudentSection $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'section' => $model->section]);
                 }
            ],
        ],
    ]); ?>


</div>
