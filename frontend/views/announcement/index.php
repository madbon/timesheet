<?php

use common\models\Announcement;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Files;
use yii\widgets\LinkPager;
use common\models\AnnouncementSeen;
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

    <?php // Pjax::begin(); ?>
    

    <?php 
    // echo GridView::widget([
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
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <div class="container">
                <div class="card">
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
        </div>
    </div>

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
                    <?php // print_r($modelUpload); exit; ?>
                    <div id="form-announcement" class="card-content" style="display:none;">
                        <?= $this->render('create', [
                            'model' => $model,
                            'modelUpload' => $modelUpload,
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
                    <?= Html::a('Today ('.(Yii::$app->getModule('admin')->unseenAnnouncement(date('Y-m-d'))).')',['index', 'AnnouncementSearch[date_time]' => 'today'],[
                        'class' => $searchModel->date_time == 'today' ? 'btn btn-dark' : 'btn btn-outline-dark', 
                        'style' => 'border-radius:25px; padding-left:20px; padding-right:20px;']) ?>

                    <?= Html::a('Yesterday ('.(Yii::$app->getModule('admin')->unseenAnnouncement(date('Y-m-d', strtotime('-1 day')))).')', ['index', 'AnnouncementSearch[date_time]' => 'yesterday'], [
                        'class' => $searchModel->date_time == 'yesterday' ? 'btn btn-dark' : 'btn btn-outline-dark',
                        'style' => 'border-radius:25px; padding-left:20px; padding-right:20px;']) ?>

                    <?= Html::a('All ('.(Yii::$app->getModule('admin')->unseenAnnouncement()).')',['index', 'AnnouncementSearch[date_time]' => 'all-days'],[
                        'class' => $searchModel->date_time == 'all-days' ? 'btn btn-dark' : 'btn btn-outline-dark',
                        'style' => 'border-radius:25px; padding-left:20px; padding-right:20px;']) ?>

                    <?= Yii::$app->user->can('announcement-create') ? Html::a('My Posts',['index', 'AnnouncementSearch[date_time]' => 'my-post'],[
                        'class' => $searchModel->date_time == 'my-post' ? 'btn btn-dark' : 'btn btn-outline-dark',
                        'style' => 'border-radius:25px; padding-left:20px; padding-right:20px;']) : "" ?>
                </div>

                <?php foreach ($dataProvider->models as $row) { ?>

                    <?php
                        $annSeen = new AnnouncementSeen();    
                        if(!AnnouncementSeen::find()->where(['announcement_id' => $row->id, 'user_id' => Yii::$app->user->identity->id])->exists())
                        {
                            $annSeen->announcement_id = $row->id;
                            $annSeen->user_id = Yii::$app->user->identity->id;
                            $annSeen->date_time = date('Y-m-d H:i:s');
                            $annSeen->save();
                        }
                    ?>
                    
                    <div class="card" >
                        <div style="text-align: right; padding-top:0; margin-top:0; margin-top:-10px;">
                            <?= $row->user_id == Yii::$app->user->identity->id ? Html::button('<i class="fas fa-edit"></i>', ['value'=>Url::to('@web/announcement/update?id='.$row->id), 'class' => 'btn btn-outline-secondary btn-sm modalButton','style' => '']) : "" ?>
                            <?= ($row->user_id == Yii::$app->user->identity->id ? Html::a('<i class="fas fa-trash-alt"></i>', Url::to(['delete', 'id' => $row->id]), [
                                            'class' => 'btn btn-outline-secondary btn-sm',
                                            'style' => '',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this announcement?',
                                                'method' => 'post',
                                            ],
                            ]) : "") ?>
                        </div>
                        <div class="card-title">
                            <?= $row->content_title ?>

                            <?php if($row->viewer_type == "selected_program"){ ?>
                                <p style="font-weight: normal; font-size:11px;">
                                    <code>ATTENTION <i class="fas fa-bullhorn"></i> </code>
                                    <?php foreach ($row->announcementProgramTags as $tags) { ?>
                                        <span style='background:#ae0505; color:white; padding-left:7px; padding-right:7px; border-radius:25px;'><?= $tags->program->abbreviation; ?></span>
                                    <?php } ?>
                                </p>
                            <?php }else if($row->viewer_type == "assigned_program"){ ?>
                                <!-- <p style="font-weight: normal; font-size:11px;">
                                    <code>ATTENTION <i class="fas fa-bullhorn"></i> </code>
                                    <?php //echo "<pre>"; print_r($row->coordinatorPrograms); exit; ?>
                                    <?php if(!empty($row->user->coordinatorPrograms)){ ?>
                                        <?php foreach ($row->user->coordinatorPrograms as $assProg) { ?>
                                            <span style='background:#ae0505; color:white; padding-left:7px; padding-right:7px; border-radius:25px;'><?= $assProg->program->abbreviation; ?></span>
                                        <?php } ?>
                                    <?php } ?>
                                </p> -->

                                <p style="font-weight: normal; font-size:11px;">
                                    <code>ATTENTION <i class="fas fa-bullhorn"></i> </code>
                                    <?php foreach ($row->announcementProgramTags as $tags) { ?>
                                        <span style='background:#ae0505; color:white; padding-left:7px; padding-right:7px; border-radius:25px;'><?= $tags->program->abbreviation; ?></span>
                                    <?php } ?>
                                </p>
                            <?php }else{ ?>
                                <p style="font-weight: normal; font-size:11px;">
                                    <code>ATTENTION <i class="fas fa-bullhorn"></i>  <span style='background:#ae0505; color:white; padding-left:7px; padding-right:7px; border-radius:25px;'>ALL PROGRAMS/COURSES</span></code>
                                </p>
                            <?php } ?>
                        </div>
                        <div class="card-content">
                        
                            <p style="white-space: pre-line;"><?= $row->content ?></p>

                            <?php
                                $files = Files::find()->where(['model_id' => $row->id, 'model_name' => 'Announcement'])->all();

                                $fileContent = "";
                                // foreach ($files as $file)
                                // {
                                                                    
                                // }

                                $fileContent .= '<div id="image-container-'.$row->id.'" style="position:relative;">';
                                $index = 0;
                                foreach ($files as $file) {
                                    // ...
                                    if (in_array($file->extension, ['jpg','jpeg','png','gif'])) {
                                        $fileContent .= '<div class="image-wrapper-'.$row->id.'" data-index="' . $index . '" style="' . ($index === 0 ? '' : 'display:none;') . '">';
                                        $fileContent .= Html::img(Url::to(['preview', 'id' => $file->id]), [
                                            'alt'=>'My Image',
                                            'style' => 'width:100%;',
                                            'class' => 'img-responsive'
                                        ]).($file->user_id == Yii::$app->user->identity->id ? Html::a('<i class="fas fa-trash-alt"></i>', Url::to(['delete-file', 'id' => $file->id]), [
                                            'class' => 'btn btn-outline-danger btn-sm',
                                            'style' => 'border-radius:25px; position:absolute; right:20px; top:20px;',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this image?',
                                                'method' => 'post',
                                            ],
                                        ]) : "");
                                        $fileContent .= '</div>';
                                        $index++;
                                    }
                                    else
                                    {
                                        $filePath = 'uploads/' . $file->file_hash . '.' . $file->extension;
                                        if (file_exists($filePath)) {
                                            if (in_array($file->extension, ['pdf']))
                                            {
                                                if($file->user_id == Yii::$app->user->identity->id)
                                                {
                                                    $fileContent .= "<div style='margin-top:10px;'>".Html::a('<i class="fas fa-file-pdf"></i> '.Html::encode($file->file_name . '.' . $file->extension), Url::to(['preview', 'id' => $file->id]), ['class' => 'btn btn-outline-dark btn-sm', 'style' => 'border-radius:25px 0px 0px 25px; border-right:none;','target' => '_blank']).Html::a('X', Url::to(['delete-file', 'id' => $file->id]), [
                                                        'class' => 'btn btn-outline-dark btn-sm',
                                                        'style' => 'border-radius:0px 25px 25px 0px; border-left:none;',
                                                        'data' => [
                                                            'confirm' => 'Are you sure you want to delete this file?',
                                                            'method' => 'post',
                                                        ],
                                                    ])."</div>";
                                                }
                                                else
                                                {
                                                    $fileContent .= Html::a('<i class="fas fa-file-pdf"></i> '.Html::encode($file->file_name . '.' . $file->extension), Url::to(['preview', 'id' => $file->id]), ['class' => 'btn btn-outline-dark btn-sm', 'style' => 'border-radius:25px;','target' => '_blank']);
                                                }
                                                
                                            }
                                            else
                                            {
                                                $fileExt = "";
                                                if(in_array($file->extension,['xlsx','xls']))
                                                {
                                                    $fileExt = '<i class="fas fa-file-excel"></i> ';
                                                }
                                                else if(in_array($file->extension,['csv']))
                                                {
                                                    $fileExt = '<i class="fas fa-file-csv"></i> ';
                                                }
                                                else if(in_array($file->extension,['docx']))
                                                {
                                                    $fileExt = '<i class="fas fa-file-word"></i> ';
                                                }
                                                else if(in_array($file->extension,['pptx']))
                                                {
                                                    $fileExt = '<i class="fas fa-file-powerpoint"></i> ';
                                                }


                                                if($file->user_id == Yii::$app->user->identity->id)
                                                {
                                                    $fileContent .= Html::a($fileExt.Html::encode($file->file_name . '.' . $file->extension), Url::to(['download', 'id' => $file->id]), ['class' => 'btn btn-outline-dark btn-sm', 'style' => 'border-radius:25px 0px 0px 25px; border-right:none;','target' => '_blank']).Html::a('X', Url::to(['delete-file', 'id' => $file->id]), [
                                                        'class' => 'btn btn-outline-dark btn-sm',
                                                        'style' => 'border-radius:0px 25px 25px 0px; border-left:none;',
                                                        'data' => [
                                                            'confirm' => 'Are you sure you want to delete this file?',
                                                            'method' => 'post',
                                                        ],
                                                    ]);
                                                }
                                                else
                                                {
                                                    $fileContent .= Html::a($fileExt.Html::encode($file->file_name . '.' . $file->extension), Url::to(['download', 'id' => $file->id]), ['class' => 'btn btn-outline-dark btn-sm', 'style' => 'border-radius:25px;','target' => '_blank']);
                                                }
                                            }
                                        }    
                                    }
                                    // ...
                                }

                                $fileContent .= '<button id="previous-button-'.$row->id.'" style="position:absolute;left:0;top:50%;display:none;" class="btn btn-link"><i style="font-size:50px; color:#ff000054;" class="fas fa-chevron-circle-left"></i></button>';
                                $fileContent .= '<button id="next-button-'.$row->id.'" style="position:absolute;right:0;top:50%;display:none;" class="btn btn-link"><i style="font-size:50px; color:#ff000054;" class="fas fa-chevron-circle-right"></i></button>';
                                $fileContent .= '</div>';

                                echo $fileContent;
                            ?>

                        <?php
                        $script = <<<JS
                        $(document).ready(function() {
                            const \$imageWrapper = $(".image-wrapper-" + $row->id);
                            const \$previousButton = $("#previous-button-" + $row->id);
                            const \$nextButton = $("#next-button-" + $row->id);
                            const transitionDuration = 200; // duration of the transition in milliseconds

                            if (\$imageWrapper.length > 1) {
                                \$previousButton.show();
                                \$nextButton.show();
                            }

                            \$previousButton.click(function() {
                                const currentIndex = parseInt(\$imageWrapper.filter(":visible").data("index"));
                                const newIndex = currentIndex === 0 ? \$imageWrapper.length - 1 : currentIndex - 1;

                                \$imageWrapper.filter(":visible").fadeOut(transitionDuration, function() {
                                    \$imageWrapper.filter('[data-index="' + newIndex + '"]').fadeIn(transitionDuration);
                                });
                            });

                            \$nextButton.click(function() {
                                const currentIndex = parseInt(\$imageWrapper.filter(":visible").data("index"));
                                const newIndex = (currentIndex + 1) % \$imageWrapper.length;

                                \$imageWrapper.filter(":visible").fadeOut(transitionDuration, function() {
                                    \$imageWrapper.filter('[data-index="' + newIndex + '"]').fadeIn(transitionDuration);
                                });
                            });
                        });
                        JS;

                        $this->registerJs($script, \yii\web\View::POS_READY);
                        ?>
                       

                        </div>
                        <div class="card-footer">
                            Posted by: <?= $row->user->userFullname ?>  on <?=  date('F j, Y h:i a',strtotime($row->date_time)); ?>
                        </div>
                    </div>
                <?php } ?>
                <div style="display:flex; justify-content:center;">
                    <?php
                        echo LinkPager::widget([
                            'pagination' => $dataProvider->pagination,
                        ]);
                    ?>
                </div>
            </div>
            
        </div>
        <div class="col-sm-3">
        </div>        
    </div>
    <?php } ?>

    
    
    <?php // Pjax::end(); ?>

</div>
