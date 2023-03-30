<?php

use common\models\SubmissionThread;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Files;

/** @var yii\web\View $this */
/** @var common\models\SubmissionThreadSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    /* GRID STYLE */
        
    table.table thead tr th
        {
            font-size:11px;
            font-weight: normal;
            text-transform: uppercase;
            /* background:#af4343; */
            background: #ffdbdb;
            color:#af4343;
            text-align: center;
        }

        table.table thead tr td select option,table.table thead tr td select, table.table thead tr td input
        {
            font-size: 11px;
        }

        table.table thead tr th a
        {
            font-size:11px;
            text-decoration: none;
            font-weight: normal;
            color:#af4343;
        }

        table.table tbody tr td
        {
            font-size:11px;
            border-bottom: 1px solid #e6e6e6;
            border-top:1px solid #e6e6e6;
            /* background:white; */
        }

        table.table tbody tr td a
        {
            font-size:11px;
        }
        
        table.table
        {
            background-color: white;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        /* GRID STYLE _END */
</style>
<div class="submission-thread-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <!-- <?= Yii::$app->user->can('create-transaction') ? Html::a('Submit Document', ['create'], ['class' => 'btn btn-outline-primary']) : "" ?>

        <?= Yii::$app->user->can('create-activity-reminder') ? Html::a('Create Activity Reminder', ['create','transaction_type' => 'ACTIVITY_REMINDER'], ['class' => 'btn btn-outline-primary']) : "" ?> -->

        <?php foreach ($documentSender as $key2 => $row2) { ?>
            <?= Html::a($row2['action_title'], ['create',
            'ref_document_type_id' => $row2['ref_document_type_id'],
            'required_uploading' => $row2['required_uploading'],
            ], ['class' => 'btn btn-warning', 'style' => 'border-radius:10px;']) ?>
        <?php } ?>
    </p>

    <p style="text-align: center;">
    <?php foreach ($documentAss as $key => $row) { ?>
        
       <?php 
        if($searchModel->ref_document_type_id == $row['ref_document_type_id'])
        {
            echo Html::a($row['title'],['index',
            'SubmissionThreadSearch[ref_document_type_id]' => $row['ref_document_type_id'],
            ],
            [
                'class' => 'btn btn-danger btn-sm',
                'style' => 'border-radius:25px;',
                ]
            ); 
        }
        else
        {
            echo Html::a($row['title'],['index',
            'SubmissionThreadSearch[ref_document_type_id]' => $row['ref_document_type_id'],
            ],
            [
                'class' => 'btn btn-outline-danger btn-sm',
                'style' => 'border-radius:25px;',
                ]
            ); 
        }
       
       
       ?>
    <?php } ?>
    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model, $key, $index, $column) {
            if(Yii::$app->getModule('admin')->documentAssignedAttrib($model->ref_document_type_id,'RECEIVER'))
            {
                if(!empty($model->submissionThreadSeen->submission_thread_id))
                {
                    if($model->submissionThreadSeen->submission_thread_id == $model->id && $model->submissionThreadSeen->user_id == Yii::$app->user->identity->id){
                        return ['style' => 'background-color:#ffffff;'];
                    }
                    else
                    {
                        return ['style' => 'background-color: #ffdbdb'];
                    }
                }
                else
                {
                    return ['style' => 'background-color: #ffdbdb'];
                }
            }
            
        },
        'tableOptions' => ['class' => 'table table-condensed table-hover'],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'user_id',
            // 'ref_document_type_id',
            // 'remarks:ntext',
            [
                'label' => "TASK TYPE",
                'attribute' => 'ref_document_type_id',
                'format' => 'raw',
                'value' => function($model)
                {
                    $type = "<label style='background:#dc3545; color:white; border:1px solid #dc3545; border-radius:25px; padding:2px; padding-left:7px; padding-right:7px;'>".$model->documentType->title."</label>";
                    return $type;
                },
                'filter' => \yii\helpers\ArrayHelper::map((\common\models\DocumentType::find()->all()), 'id', 'title'),
            ],
            [
                'label' => "CREATED BY",
                'attribute' => Yii::$app->getModule('admin')->documentTypeAttrib($searchModel->ref_document_type_id,'enable_tagging') ? false : 'user_id',
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
                'visible' => Yii::$app->getModule('admin')->documentTypeAttrib($searchModel->ref_document_type_id,'enable_tagging') ? true : false,
                'value' => function($model) use($searchModel)
                {
                    return "<span style='color:#dc3545; font-size:10px; text-transform:uppercase; font-weight:bold;'>".$model->taggedUser->userFullName."</span>";
                }
            ],
            [
                'label' => 'PROGRAM/COURSE',
                'attribute' => 'program',
                'format' => 'raw',
                'visible' => Yii::$app->user->can('OjtCoordinator') || Yii::$app->getModule('admin')->documentTypeAttrib($searchModel->ref_document_type_id,'enable_tagging'),
                'value' => function($model) use($searchModel)
                {
                    if(Yii::$app->getModule('admin')->documentTypeAttrib($searchModel->ref_document_type_id,'enable_tagging'))
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
                'filter' => \yii\helpers\ArrayHelper::map((\common\models\RefProgram::find()->all()), 'id', 'title'),
            ],
            [
                'label' => 'COMPANY',
                'attribute' => 'company',
                'visible' => Yii::$app->user->can('OjtCoordinator'),
                'value' => function($model) use($searchModel)
                {
                    if(Yii::$app->getModule('admin')->documentTypeAttrib($searchModel->ref_document_type_id,'enable_tagging'))
                    {
                        return !empty($model->taggedUser->userCompany->company->name) ? $model->taggedUser->userCompany->company->name : "";
                    }
                    else
                    {
                        return !empty($model->user->userCompany->company->name) ? $model->user->userCompany->company->name : "";
                    }
                    
                },
                'filter' => \yii\helpers\ArrayHelper::map((\common\models\Company::find()->all()), 'id', 'name'),
            ],
            [
                'label' => 'DEPARTMENT',
                'attribute' => 'department',
                'visible' => Yii::$app->user->can('OjtCoordinator'),
                'value' => function($model) use($searchModel)
                {
                    if(Yii::$app->getModule('admin')->documentTypeAttrib($searchModel->ref_document_type_id,'enable_tagging'))
                    {
                        return !empty($model->taggedUser->department->title) ? $model->user->department->title : "";
                    }
                    else
                    {
                        return !empty($model->user->department->title) ? $model->user->department->title : "";
                    }
                    
                },
                'filter' => \yii\helpers\ArrayHelper::map((\common\models\Department::find()->all()), 'id', 'title'),
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
            [
                'attribute' => 'date_time',
                'format' => 'raw',
                'filter' => Html::activeInput('date', $searchModel, 'date_time', [
                    'class' => 'form-control',
                    'placeholder' => Yii::t('app', 'Select date'),
                ]),
                'value' => function ($model) {
                    $dateTime = date('F j, Y h:i a',strtotime($model->date_time));
                    return $dateTime;
                },
            ],
            [
                'class' => ActionColumn::className(),
                'template' => Yii::$app->getModule('admin')->documentAssignedAttrib($searchModel->ref_document_type_id,'SENDER') ?  '{view} {update} {delete}' : '{view}',
                'urlCreator' => function ($action, SubmissionThread $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>

