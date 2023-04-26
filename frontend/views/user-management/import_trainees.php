<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\RefProgram;
use common\models\CoordinatorPrograms;

/* @var $this yii\web\View */
/* @var $model app\models\UploadForm */

$this->title = 'Import Trainees';
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index','UserDataSearch[item_name]' => 'Trainee']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="container-fluid">

<h1><?= Html::encode($this->title) ?></h1>


<?php 
    
    echo "<strong>Step #1:</strong> Select program/course: ";
    if(Yii::$app->user->can('import-based-on-assigned-program'))
    {
        $program = CoordinatorPrograms::find()->where(['user_id' => Yii::$app->user->identity->id])
        ->all();
        // ->createCommand()->rawSql;

        if($program)
        {
            foreach ($program as $prog) {
                if($prog->program->id == $program_id)
                {
                    echo Html::a($prog->program->abbreviation,[Yii::$app->controller->action->id,'program_id' => $prog->program->id],[
                        'class' => 'btn btn-success btn-sm',
                        'style' => 'border-radius:25px;',
                    ]);
                }
                else
                {
                    echo Html::a($prog->program->abbreviation,[Yii::$app->controller->action->id,'program_id' => $prog->program->id],[
                        'class' => 'btn btn-outline-success btn-sm',
                        'style' => 'border-radius:25px;',
                    ]);
                }
            }
        }
        else
        {
            echo 'You have no program/course assigned.';
        }
        
        
    }
    else
    {
        $program = RefProgram::find()->all();
        foreach ($program as $prog) {
            if($prog->id == $program_id)
            {
                echo Html::a($prog->abbreviation,[Yii::$app->controller->action->id,'program_id' => $prog->id],[
                    'class' => 'btn btn-success btn-sm',
                    'style' => 'border-radius:0;',
                ]);
            }
            else
            {
                echo Html::a($prog->abbreviation,[Yii::$app->controller->action->id,'program_id' => $prog->id],[
                    'class' => 'btn btn-outline-success btn-sm',
                    'style' => 'border-radius:0;',
                ]);
            }
        }
    }
   
?>

<p style="margin-top:25px;">
    <?php
        if($program_id)
        {
            echo "<span><strong>Step #2: </strong> Download template:</span> ".Html::a('<i class="fas fa-file-excel"></i> trainees_import_template.xlxs', ['download-template'], ['class' => 'btn btn-success btn-sm',
            'style' => ''
        ]);
        }
    
    ?>
</p>



<?php if($program_id){ ?>
   
    <div style="margin-top:25px;">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= "<strong>Step #3: </strong>".$form->field($model, 'file')->fileInput()->label(false) ?>

        <div class="form-group" style="margin-top:50px;">
            <?= "<strong>Step #4: </strong>".Html::submitButton('<i class="fas fa-table"></i> Preview Excel Data of Trainees', ['class' => 'btn btn-primary btn-sm']) ?>
        </div>

    <?php ActiveForm::end(); ?>
    </div>
<?php } ?>

</div>
