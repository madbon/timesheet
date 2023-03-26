<?php

use common\models\SubmissionReply;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\SubmissionReplySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Submission Replies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="submission-reply-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Submission Reply', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'submission_thread_id',
            'user_id',
            'message:ntext',
            'date_time',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SubmissionReply $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
