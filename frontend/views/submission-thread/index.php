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
        <?= Yii::$app->user->can('create-transaction') ? Html::a('Create Transaction', ['create'], ['class' => 'btn btn-success']) : "" ?>
    </p>


    <p style="text-align: center;">
        <?php
        if($documentTypeSubmitted)
        {
            foreach ($documentTypeSubmitted as $docSub) {
                if($docSub->id == $searchModel->ref_document_type_id)
                {
                    echo Html::a($docSub->title,['index','SubmissionThreadSearch[ref_document_type_id]' => $docSub->id],['class' => 'btn btn-dark btn-sm', 'style' => 'border-radius:25px;']);
                }
                else
                {
                    echo Html::a($docSub->title,['index','SubmissionThreadSearch[ref_document_type_id]' => $docSub->id],['class' => 'btn btn-outline-dark btn-sm', 'style' => 'border-radius:25px;']);
                }
                
            }
        }

        if($documentTypeReceived)
        {
            foreach ($documentTypeReceived as $docRec) {
                if($docRec->id == $searchModel->ref_document_type_id)
                {
                    echo Html::a($docRec->title,['index','SubmissionThreadSearch[ref_document_type_id]' => $docRec->id],['class' => 'btn btn-dark btn-sm', 'style' => 'border-radius:25px;']);
                }
                else
                {
                    echo Html::a($docRec->title,['index','SubmissionThreadSearch[ref_document_type_id]' => $docRec->id],['class' => 'btn btn-outline-dark btn-sm', 'style' => 'border-radius:25px;']);
                }
                
            }
        }
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'user_id',
            // 'ref_document_type_id',
            // 'remarks:ntext',
            [
                'label' => "CREATED BY",
                'format' => 'raw',
                'value' => function($model)
                {
                    return $model->user->userFullName;
                }
            ],
            // [
            //     'label' => "TRANSACTION TYPE",
            //     'format' => 'raw',
            //     'value' => function($model)
            //     {
            //         $type = "<label style='background:#e4e4e4; border:1px solid #d4d4d4; border-radius:5px; padding:2px;'>".$model->documentType->title."</label>";
            //         return $type;
            //     }
            // ],
            [
                'label' => "SUBJECT",
                'format' => 'raw',
                'value' => function($model)
                {
                    $subject = "<strong>".$model->subject."</strong>";
                    return $subject;
                }
            ],
            [
                'label' => "REMARKS",
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
                'label' => 'DATE/TIME',
                'format' => 'raw',
                'value' => function($model)
                {
                    $dateTime = date('F j, Y h:i a',strtotime($model->date_time));
                    return $dateTime;
                }

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
