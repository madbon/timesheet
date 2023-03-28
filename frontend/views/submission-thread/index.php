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

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="submission-thread-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::$app->user->can('create-transaction') ? Html::a('Submit Document', ['create'], ['class' => 'btn btn-outline-primary']) : "" ?>

        <?= Yii::$app->user->can('create-activity-reminder') ? Html::a('Create Activity Reminder', ['create','transaction_type' => 'ACTIVITY_REMINDER'], ['class' => 'btn btn-outline-primary']) : "" ?>
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
                'class' => 'btn btn-danger',
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
                'class' => 'btn btn-outline-danger',
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
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'user_id',
            // 'ref_document_type_id',
            // 'remarks:ntext',
            [
                'label' => "CREATED BY",
                'attribute' => 'user_id',
                'format' => 'raw',
                'value' => function($model)
                {
                    return $model->user->userFullName;
                }
            ],
            [
                'label' => 'PROGRAM/COURSE',
                'attribute' => 'program',
                'format' => 'raw',
                'value' => function($model)
                {
                    $major = !empty($model->user->programMajor->title) ? $model->user->programMajor->title : "";
                    return (!empty($model->user->program->title) ? $model->user->program->title : "")."<br/>".$major;
                },
                'filter' => \yii\helpers\ArrayHelper::map((\common\models\RefProgram::find()->all()), 'id', 'title'),
            ],
            [
                'label' => 'COMPANY',
                'attribute' => 'company',
                'value' => function($model)
                {
                    return !empty($model->user->userCompany->company->name) ? $model->user->userCompany->company->name : "";
                }
            ],
            [
                'label' => 'DEPARTMENT',
                'attribute' => 'department',
                'value' => function($model)
                {
                    return !empty($model->user->department->title) ? $model->user->department->title : "";
                }
            ],
            [
                'label' => "TRANSACTION TYPE",
                'attribute' => 'ref_document_type_id',
                'format' => 'raw',
                'value' => function($model)
                {
                    $type = "<label style='background:#e4e4e4; border:1px solid #d4d4d4; border-radius:5px; padding:2px;'>".$model->documentType->title."</label>";
                    return $type;
                },
                'filter' => \yii\helpers\ArrayHelper::map((\common\models\DocumentType::find()->all()), 'id', 'title'),
            ],
            [
                'label' => "SUBJECT",
                'format' => 'raw',
                'attribute' => 'subject',
                'value' => function($model)
                {
                    $subject = "<strong>".$model->subject."</strong>";
                    return $subject;
                }
            ],
            [
                'label' => "REMARKS",
                'attribute' => 'remarks',
                'format' => 'raw',
                'value' => function($model)
                {
                    $remarks = !empty($model->remarks) ? "<p style='white-space:pre-line;'>".(Yii::$app->getModule('admin')->truncateText($model->remarks))."</p>" : "";

                    $files = Files::find()->where(['model_id' => $model->id, 'model_name' => 'SubmissionThread'])->all();

                    $fileContent = "";
                    foreach ($files as $file)
                    {
                        $fileContent .= Html::a(Html::encode($file->file_name . '.' . $file->extension), Url::to(['download', 'id' => $file->id]), ['class' => 'btn btn-outline-secondary', 'style' => 'border-radius:25px;']);
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
                'urlCreator' => function ($action, SubmissionThread $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
