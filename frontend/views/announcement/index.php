<?php

use common\models\Announcement;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\AnnouncementSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Announcements';
// $this->params['breadcrumbs'][] = $this->title;
?>
 <style>
    .card {
            /* width: 350px; */
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            padding: 20px;
            margin-bottom:20px;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .card-content {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .card-footer {
            font-size: 14px;
            color: #999;
            text-align: right;
        }

        .show-form
        {
            cursor:pointer;
        }
</style>
<div class="announcement-index">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 
    // GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     'filterModel' => $searchModel,
    //     'columns' => [
    //         ['class' => 'yii\grid\SerialColumn'],

    //         'id',
    //         'user_id',
    //         'content:ntext',
    //         'date_time',
    //         [
    //             'class' => ActionColumn::className(),
    //             'urlCreator' => function ($action, Announcement $model, $key, $index, $column) {
    //                 return Url::toRoute([$action, 'id' => $model->id]);
    //              }
    //         ],
    //     ],
    // ]); 
    ?>

    <?php if(Yii::$app->user->can('announcement-create')){ ?>
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <div class="container">
                <div class="card">
                    <div class="card-title">
                        <div class="row show-form">
                            <div class="col-sm-6">
                                Create Announcement <i class="fas fa-bullhorn"></i>
                            </div>
                            <div class="col-sm-6">
                           
                                <p class="show-form" style="float:right;"><i class="fas fa-chevron-down pull-right"></i></p>
                                <?php
                                    $this->registerJs("
                                        $('.show-form').click(function(){
                                            $('#form-announcement').slideDown(300);
                                        });
                                    ");
                                ?>
                            </div>
                        </div>
                    </div>
                    <div id="form-announcement" class="card-content" style="display:none;">
                        <?= $this->render('create', [
                            'model' => $model,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
    <?php } ?>

    <?php if(Yii::$app->user->can('announcement-index')){ ?>
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <div class="container">
                <div style="margin-bottom:10px;">
                    <?= Html::a('Today',['index'],['class' => 'btn btn-dark', 'style' => 'border-radius:25px; padding-left:20px; padding-right:20px;']) ?>
                    <?= Html::a('Yesterday',['index'],['class' => 'btn btn-outline-dark','style' => 'border-radius:25px; padding-left:20px; padding-right:20px;']) ?>
                    <?= Html::a('All',['index'],['class' => 'btn btn-outline-dark','style' => 'border-radius:25px; padding-left:20px; padding-right:20px;']) ?>
                    <?= Html::a('My Posts',['index'],['class' => 'btn btn-outline-dark','style' => 'border-radius:25px; padding-left:20px; padding-right:20px;']) ?>
                </div>

                <?php foreach ($dataProvider->query->all() as $row) { ?>
                    
                    <div class="card">
                        <div class="card-title">
                            <?= $row->content_title ?>
                        </div>
                        <div class="card-content">
                            <p style="white-space: pre-line;"><?= $row->content ?></p>
                        </div>
                        <div class="card-footer">
                            Posted by: <?= $row->user->userFullname ?>  on <?=  date('F j, Y h:i a',strtotime($row->date_time)); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
    <?php } ?>

    

    <?php Pjax::end(); ?>

</div>
