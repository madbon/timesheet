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

$this->title = 'Threads/Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="submission-thread-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Thread/Activity', ['create'], ['class' => 'btn btn-success']) ?>
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
                'label' => false,
                'format' => 'raw',
                'value' => function($model)
                {
                    return $model->user->userFullName;
                }
            ],
            [
                'label' => false,
                'format' => 'raw',
                'value' => function($model)
                {
                    $type = "<label style='background:#e4e4e4; border:1px solid #d4d4d4; border-radius:5px; padding:2px;'>".$model->documentType->title."</label>";
                    return $type;
                }
            ],
            [
                'label' => false,
                'format' => 'raw',
                'value' => function($model)
                {
                    $subject = "<strong>".$model->subject."</strong>";
                    return $subject;
                }
            ],
            [
                'label' => false,
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
