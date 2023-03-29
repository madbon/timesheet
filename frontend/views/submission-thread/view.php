<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\Files;

/** @var yii\web\View $this */
/** @var common\models\SubmissionThread $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index', 'SubmissionThreadSearch[ref_document_type_id]' => $model->ref_document_type_id]];
$this->params['breadcrumbs'][] = "Details";
\yii\web\YiiAsset::register($this);
?>
<div class="submission-thread-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
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
                'label' => "REMARKS",
                'attribute' => 'remarks',
                'format' => 'raw',
                'value' => function($model)
                {
                    $remarks = !empty($model->remarks) ? "<p style='white-space:pre-line; font-style:italic;'><code> - </code>".($model->remarks)."</p>" : "";

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
