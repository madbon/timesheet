<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $rows array */

$this->title = 'Excel File Data of Trainees';


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
            'attribute' => 'student_idno',
            'label' => 'Student ID',
            'value' => function($model)
            {
                return $model[0];
            }
        ],
        [
            'attribute' => 'fname',
            'label' => 'First Name',
            'value' => function($model)
            {
                return $model[1];
            }
        ],
        [
            'attribute' => 'mname',
            'label' => 'Middle Name',
            'value' => function($model)
            {
                return $model[2];
            }
        ],
        [
            'attribute' => 'sname',
            'label' => 'Surname',
            'value' => function($model)
            {
                return $model[3];
            }
        ],
        [
            // 'attribute' => 'sname',
            'label' => 'Suffix',
            'value' => function($model)
            {
                return $model[4];
            }
        ],
        [
            // 'attribute' => 'sname',
            'label' => 'Birth Date',
            'value' => function($model)
            {
                return $model[5];
            }
        ],
        [
            // 'attribute' => 'sname',
            'label' => 'Sex',
            'value' => function($model)
            {
                return $model[6];
            }
        ],
        [
            // 'attribute' => 'sname',
            'label' => 'Mobile No.',
            'value' => function($model)
            {
                return $model[7];
            }
        ],
        [
            // 'attribute' => 'sname',
            'label' => 'Address',
            'value' => function($model)
            {
                return $model[8];
            }
        ],
        [
            // 'attribute' => 'student_idno',
            'label' => 'Course/Program',
            'value' => function($model) use($program_id)
            {
                // Yii::$app->getModule('admin')->getMajorCode($model[9],$program_id);
                return Yii::$app->getModule('admin')->getProgram($program_id);
            }
        ],
        [
            // 'attribute' => 'student_idno',
            'label' => 'Major',
            'value' => function($model) use($program_id)
            {
                return $model[9];
            }
        ],
        [
            // 'attribute' => 'student_idno',
            'label' => 'Year',
            'value' => function($model) use($program_id)
            {
                return $model[10];
            }
        ],
        [
            // 'attribute' => 'student_idno',
            'label' => 'Section',
            'value' => function($model) use($program_id)
            {
                return $model[11];
            }
        ],
        [
            // 'attribute' => 'sname',
            'label' => 'Email',
            'value' => function($model)
            {
                return $model[12];
            }
        ],
        
    ],
]); ?>
<br/>
<?= Html::a('<i class="fas fa-file-import"></i> Import Data',['save-imported-trainees','program_id' => $program_id],['class' => 'btn btn-warning']) ?>
