<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\Files;
use yii\widgets\ActiveForm;
use common\models\EvaluationForm;

/** @var yii\web\View $this */
/** @var common\models\SubmissionThread $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index', 'SubmissionThreadSearch[ref_document_type_id]' => $model->ref_document_type_id]];
$this->params['breadcrumbs'][] = "Details";
\yii\web\YiiAsset::register($this);
?>
<style>
table.table tbody tr th
{
    text-transform: uppercase;
    font-size:12px;
}

card {
    /* background-color: #f2f2f2; */
    border-radius: 20px;
    padding: 10px;
    margin: 10px;
    /* max-width: 70%; */
    position: relative;
    font-family: Arial, sans-serif;
    font-size: 16px;
    line-height: 1.5;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}
.card:before {
    content: "";
    position: absolute;
    top: 0;
    border-top: 20px solid transparent;
    border-bottom: 20px solid transparent;
    /* background: black; */
    /* box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); */
}
.left-card:before {
    left: -20px;
    top:2px;
    border-right: 20px solid #f2f2f2;
}
.right-card:before {
    right: -20px;
    top:2px;
    border-left: 20px solid #ffc107;
}
.left-card {
    float: left;
    margin-bottom: 20px;
    background-color: #f2f2f2;
    max-width: 90%;
    padding:10px;
}
.right-card {
    float: right;
    margin-bottom: 20px;
    background-color: #ffc107;
    max-width: 92%;
    padding:10px;
}
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}
</style>
<div class="submission-thread-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <div style="width:80%; margin-right:10%; margin-left:auto;">
    <p>
        <?= Yii::$app->user->identity->id == $model->user_id ? Html::a('Edit Remarks / Add Attachment', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : "" ?>
        <?php 
        // Html::a('Delete', ['delete', 'id' => $model->id], [
        //     'class' => 'btn btn-danger',
        //     'data' => [
        //         'confirm' => 'Are you sure you want to delete this item?',
        //         'method' => 'post',
        //     ],
        // ]) 
        ?>
    </p>
        <?php 
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'date_time',
                    'format' => 'raw',
                    // 'filter' => Html::activeInput('date', $model, 'date_time', [
                    //     'class' => 'form-control',
                    //     'placeholder' => Yii::t('app', 'Select date'),
                    // ]),
                    'value' => function ($model) {
                        $dateTime = date('F j, Y h:i a',strtotime($model->date_time));
                        return $dateTime;
                    },
                ],
                [
                    'label' => "TASK TYPE",
                    'attribute' => 'ref_document_type_id',
                    'format' => 'raw',
                    'value' => function($model)
                    {
                        $type = "<label style='background:#dc3545; color:white; border:1px solid #dc3545; border-radius:25px; padding:2px; padding-left:7px; padding-right:7px;'>".$model->documentType->title."</label>";
                        return $type;
                    },
                    // 'filter' => \yii\helpers\ArrayHelper::map((\common\models\DocumentType::find()->all()), 'id', 'title'),
                ],
                [
                    'label' => "CREATED BY",
                    'attribute' => Yii::$app->getModule('admin')->documentTypeAttrib($model->ref_document_type_id,'enable_tagging') ? false : 'user_id',
                    'format' => 'raw',
                    'value' => function($model)
                    {
                        $role = !empty($model->user->authAssignment->item_name) ? "<br/><code> > </code>".$model->user->authAssignment->item_name : "";
                        if($model->user->authAssignment->item_name == "CompanySupervisor")
                        {
                            return "<span style='text-transform:uppercase;'> <code> > </code>".$model->user->userFullName."</span>".$role;
                        }
                        else
                        {
                            return "<span style='color:#dc3545; font-size:10px; text-transform:uppercase; font-weight:bold;'>".$model->user->userFullName."</span>".$role;
                        }
                    }
                ],
                [
                    'label' => 'Trainee',
                    'attribute' => 'tagged_user_id',
                    'format' => 'raw',
                    'visible' => Yii::$app->getModule('admin')->documentTypeAttrib($model->ref_document_type_id,'enable_tagging') ? true : false,
                    'value' => function($model) 
                    {
                        return "<span style='color:#dc3545; font-size:10px; text-transform:uppercase; font-weight:bold;'>".$model->taggedUser->userFullName."</span>";
                    }
                ],
                [
                    'label' => 'PROGRAM/COURSE',
                    'attribute' => 'program',
                    'format' => 'raw',
                    'visible' => Yii::$app->user->can('OjtCoordinator') || Yii::$app->getModule('admin')->documentTypeAttrib($model->ref_document_type_id,'enable_tagging'),
                    'value' => function($model) 
                    {
                        if(Yii::$app->getModule('admin')->documentTypeAttrib($model->ref_document_type_id,'enable_tagging'))
                        {
                            $major = !empty($model->taggedUser->programMajor->title) ? "<code> > </code>"."Major in ".$model->taggedUser->programMajor->title : "";
                            $program = (!empty($model->taggedUser->program->title) ? "<code> > </code>".$model->taggedUser->program->title : "");
        
                        }
                        else
                        {
                            $major = !empty($model->user->programMajor->title) ? "<code> > </code>"."Major in ".$model->user->programMajor->title : "";
                            $program = (!empty($model->user->program->title) ? "<code> > </code>".$model->user->program->title : "");
        
                        }
                    
                        return $program."<br/>".$major;
                    },
                    // 'filter' => \yii\helpers\ArrayHelper::map((\common\models\RefProgram::find()->all()), 'id', 'title'),
                ],
                [
                    'label' => 'COMPANY',
                    'attribute' => 'company',
                    'visible' => Yii::$app->user->can('OjtCoordinator'),
                    'value' => function($model) 
                    {
                        if(Yii::$app->getModule('admin')->documentTypeAttrib($model->ref_document_type_id,'enable_tagging'))
                        {
                            return !empty($model->taggedUser->userCompany->company->name) ? $model->taggedUser->userCompany->company->name : "";
                        }
                        else
                        {
                            return !empty($model->user->userCompany->company->name) ? $model->user->userCompany->company->name : "";
                        }
                        
                    },
                    // 'filter' => \yii\helpers\ArrayHelper::map((\common\models\Company::find()->all()), 'id', 'name'),
                ],
                [
                    'label' => 'DEPARTMENT',
                    'attribute' => 'department',
                    'visible' => Yii::$app->user->can('OjtCoordinator'),
                    'value' => function($model) 
                    {
                        if(Yii::$app->getModule('admin')->documentTypeAttrib($model->ref_document_type_id,'enable_tagging'))
                        {
                            return !empty($model->taggedUser->department->title) ? $model->user->department->title : "";
                        }
                        else
                        {
                            return !empty($model->user->department->title) ? $model->user->department->title : "";
                        }
                        
                    },
                    // 'filter' => \yii\helpers\ArrayHelper::map((\common\models\Department::find()->all()), 'id', 'title'),
                ],
                
                // [
                //     'label' => "SUBJECT",
                //     'format' => 'raw',
                //     'attribute' => 'subject',
                //     'value' => function($model)
                //     {
                //         $subject = "<strong>".$model->subject."</strong>";
                //         return $subject;
                //     }
                // ],
                [
                    'label' => "REMARKS & UPLOADED FILE/S",
                    'attribute' => 'remarks',
                    'format' => 'raw',
                    'value' => function($model)
                    {
                        $remarks = !empty($model->remarks) ? "<p style='white-space:pre-line; font-style:italic; font-size:13px; '><code> - </code>".($model->remarks)."</p>" : "";

                        $files = Files::find()->where(['model_id' => $model->id, 'model_name' => 'SubmissionThread'])->all();

                        $fileContent = "";
                        foreach ($files as $file)
                        {
                            $filePath = 'uploads/' . $file->file_hash . '.' . $file->extension;
                            if (file_exists($filePath)) {
                                if (in_array($file->extension, ['png', 'jpg', 'jpeg', 'gif', 'pdf']))
                                {
                                    if($file->user_id == Yii::$app->user->identity->id)
                                    {
                                        $fileContent .= Html::a(Html::encode($file->file_name . '.' . $file->extension), Url::to(['preview', 'id' => $file->id]), ['class' => 'btn btn-outline-warning', 'style' => 'border-radius:25px 0px 0px 25px;','target' => '_blank']).Html::a('X', Url::to(['delete-file', 'id' => $file->id]), [
                                            'class' => 'btn btn-warning',
                                            'style' => 'border-radius:0px 25px 25px 0px;',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this file?',
                                                'method' => 'post',
                                            ],
                                        ]);
                                    }
                                    else
                                    {
                                        $fileContent .= Html::a(Html::encode($file->file_name . '.' . $file->extension), Url::to(['preview', 'id' => $file->id]), ['class' => 'btn btn-outline-warning', 'style' => 'border-radius:25px;','target' => '_blank']);
                                    }
                                    
                                }
                                else
                                {
                                    if($file->user_id == Yii::$app->user->identity->id)
                                    {
                                        $fileContent .= Html::a(Html::encode($file->file_name . '.' . $file->extension), Url::to(['download', 'id' => $file->id]), ['class' => 'btn btn-outline-warning', 'style' => 'border-radius:25px 0px 0px 25px;','target' => '_blank']).Html::a('X', Url::to(['delete-file', 'id' => $file->id]), [
                                            'class' => 'btn btn-warning',
                                            'style' => 'border-radius:0px 25px 25px 0px;',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this file?',
                                                'method' => 'post',
                                            ],
                                        ]);
                                    }
                                    else
                                    {
                                        $fileContent .= Html::a(Html::encode($file->file_name . '.' . $file->extension), Url::to(['download', 'id' => $file->id]), ['class' => 'btn btn-outline-warning', 'style' => 'border-radius:25px;','target' => '_blank']);
                                    }
                                }
                            }
                            // else
                            // {
                            //     $fileContent = "<button type='button' class='btn btn-outline-dark btn-sm' style='font-size:10px; border-radius:25px;'> The file was not uploaded properly. Please upload again.</button>";
                            // }
                            
                            
                        }
                        return $remarks.$fileContent;
                    }
                ],
            ],
        ]) 
        ?>
            
    </div>

    <!-- <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($files as $file): ?>
                    <tr>
                        <td><?= Html::encode($file->file_name . '.' . $file->extension) ?></td>
                        <td>
                            <?php if (in_array($file->extension, ['png', 'jpg', 'jpeg', 'gif', 'pdf'])): ?>
                                <?= Html::a('Preview', Url::to(['preview', 'id' => $file->id]), ['class' => 'btn btn-info', 'target' => '_blank']) ?>
                            <?php endif; ?>
                            <?= Html::a('Download', Url::to(['download', 'id' => $file->id]), ['class' => 'btn btn-primary']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> -->

</div>

<div class="container" style="margin-top:20px;">
<div class="card">
        <div class="card-body">
            <h4>Evaluation 
                <?= Html::a('<i class="fas fa-file-pdf"></i> Preview Form',['preview-pdf','trainee_id' => $model->tagged_user_id,'submission_thread_id' => $model->id],['class' => 'btn btn-outline-danger btn-sm', 'target' => '_blank']) ?>
            </h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Criteria</th>
                        <th>Max Points</th>
                        <th>Points Scored</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $evalForm = EvaluationForm::find()->where(['trainee_user_id' => $model->tagged_user_id])->all();
                    $totalPoints = 0;
                    foreach ($evalForm as $eval) { 
                        $totalPoints += $eval->points_scored;
                        ?>
                        <tr>
                            <td><?= $eval->evaluationCriteria->title ?></td>
                            <td><?= $eval->evaluationCriteria->max_points ?></td>
                            <td><?= $eval->points_scored ?></td>
                            <td><?= $eval->remarks ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h5>Total Score: <?= $totalPoints ?> points</h5>
        </div>
    </div>
</div>

<?php if($replyQuery){ ?>
<div style="width:80%; margin-left:10%; margin-right:auto;  background:#ffe9a7;  margin-top:20px; border:1px solid #ffc107;">
    <div class="thread-div" style="width:70%; margin-right:15%; margin-left:auto; padding-top:20px;">
        <?php foreach ($replyQuery as $row) { ?>
            <?php
                $files = Files::find()->where(['model_id' => $row->id, 'model_name' => 'SubmissionReply'])->all();

                $fileContent = "";
                foreach ($files as $file)
                {
                    $filePath = 'uploads/' . $file->file_hash . '.' . $file->extension;
                    if (file_exists($filePath)) {
                        if (in_array($file->extension, ['png', 'jpg', 'jpeg', 'gif', 'pdf']))
                        {
                            if($file->user_id == Yii::$app->user->identity->id)
                            {
                                $fileContent .= Html::a(Html::encode($file->file_name . '.' . $file->extension), Url::to(['preview', 'id' => $file->id]), ['class' => 'btn btn-outline-dark btn-sm', 'style' => 'border-radius:25px;','target' => '_blank']);
                                
                                // Html::a('X', Url::to(['delete-file', 'id' => $file->id]), [
                                //     'class' => 'btn btn-light',
                                //     'style' => 'border-radius:0px 25px 25px 0px;',
                                //     'data' => [
                                //         'confirm' => 'Are you sure you want to delete this file?',
                                //         'method' => 'post',
                                //     ],
                                // ]);
                            }
                            else
                            {
                                $fileContent .= Html::a(Html::encode($file->file_name . '.' . $file->extension), Url::to(['preview', 'id' => $file->id]), ['class' => 'btn btn-outline-dark btn-sm', 'style' => 'border-radius:25px;','target' => '_blank']);
                            }
                            
                        }
                        else
                        {
                            if($file->user_id == Yii::$app->user->identity->id)
                            {
                                $fileContent .= Html::a(Html::encode($file->file_name . '.' . $file->extension), Url::to(['download', 'id' => $file->id]), ['class' => 'btn btn-outline-dark btn-sm', 'style' => 'border-radius:25;','target' => '_blank']);
                                
                                // Html::a('X', Url::to(['delete-file', 'id' => $file->id]), [
                                //     'class' => 'btn btn-light',
                                //     'style' => 'border-radius:0px 25px 25px 0px;',
                                //     'data' => [
                                //         'confirm' => 'Are you sure you want to delete this file?',
                                //         'method' => 'post',
                                //     ],
                                // ]);
                            }
                            else
                            {
                                $fileContent .= Html::a(Html::encode($file->file_name . '.' . $file->extension), Url::to(['download', 'id' => $file->id]), ['class' => 'btn btn-outline-dark btn-sm', 'style' => 'border-radius:25px;','target' => '_blank']);
                            }
                        }
                    }
                }
                // echo $fileContent;
            ?>

            <?php if($row->user_id == Yii::$app->user->identity->id){ ?>

                <div class="card right-card">
                    <p>
                        <?= $row->message ?>
                    </p>

                    <p><?= $fileContent ?></p>

                    <span style="font-size:10px;"><?= $row->user->userFullName; ?>
                        <code>-</code> 
                        <span><?= date('F j, Y h:i a',strtotime($row->date_time)) ?></span>
                    </span>

                    
                </div>
                <div class="clearfix"></div>

            <?php }else{ ?>

                <div class="card left-card">
                    <p><?= $row->message ?></p>

                    <p><?= $fileContent ?></p>

                    <span style="font-size:10px;"><?= $row->user->userFullName; ?>
                        <code>-</code> 
                        <span><?= date('F j, Y h:i a',strtotime($row->date_time)) ?></span>
                    </span>
                </div>
                <div class="clearfix"></div>

            <?php } ?>
        <?php } ?>
        
        
       
    </div>
</div>
<?php } ?>

<?php if($model->documentType->enable_commenting){ ?>
<div class="submission-reply-form"  style="width:80%; margin-right:10%; margin-left:auto;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($replyModel, 'submission_thread_id')->hiddenInput()->label(false) ?>

    <?= $form->field($replyModel, 'user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($replyModel, 'message')->textarea(['rows' => 2])->label('Comment/Remarks') ?>

    <?= $form->field($modelUpload, 'imageFiles[]')->fileInput(['multiple' => true]) ?>

    <?php // $form->field($replyModel, 'date_time')->textInput() ?>

    <div class="form-group" style="text-align:right;">
        <?= Html::submitButton('SEND', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php } ?>
