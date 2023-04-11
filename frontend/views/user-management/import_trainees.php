<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\RefProgram;

/* @var $this yii\web\View */
/* @var $model app\models\UploadForm */

$this->title = 'Import Trainees';
?>



<div class="container-fluid">

<h1><?= Html::encode($this->title) ?></h1>

<?php 
    $program = RefProgram::find()->all();
    foreach ($program as $prog) {
        if($prog->id == $program_id)
        {
            echo Html::a($prog->abbreviation,[Yii::$app->controller->action->id,'program_id' => $prog->id],[
                'class' => 'btn btn-primary btn-lg',
                'style' => 'border-radius:0;',
            ]);
        }
        else
        {
            echo Html::a($prog->abbreviation,[Yii::$app->controller->action->id,'program_id' => $prog->id],[
                'class' => 'btn btn-outline-primary btn-lg',
                'style' => 'border-radius:0;',
            ]);
        }
    }

    echo Html::a('<i class="fas fa-file-excel"></i> Download Template', ['download-template'], ['class' => 'btn btn-success btn-lg',
    'style' => 'margin-left:50px;'
]);
?>



<?php if($program_id){ ?>
   
    <div style="margin-top:50px;">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'file')->fileInput()->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('<i class="fas fa-table"></i> Preview Data', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
    </div>
<?php } ?>

</div>
