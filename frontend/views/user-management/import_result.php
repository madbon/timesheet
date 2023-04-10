<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $rows array */

$this->title = 'Imported Students';


$dataProvider = new ArrayDataProvider([
    'allModels' => $rows,
    'pagination' => [
        'pageSize' => 10,
    ],
]);

// print_r($dataProvider); exit;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php
// print_r($dataProvider); exit;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'fname',
            'label' => 'First Name',
            'value' => function($model)
            {
                return $model[0];
            }
        ],
        [
            'attribute' => 'mname',
            'label' => 'Middle Name',
            'value' => function($model)
            {
                return $model[1];
            }
        ],
        [
            'attribute' => 'sname',
            'label' => 'Surname',
            'value' => function($model)
            {
                return $model[2];
            }
        ],
        [
            'attribute' => 'student_idno',
            'label' => 'Student ID',
            'value' => function($model)
            {
                return $model[3];
            }
        ],
    ],
]); ?>

<?= Html::a('Import Data',['save-imported-trainees'],['class' => 'btn btn-warning']) ?>
