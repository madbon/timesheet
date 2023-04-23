<?php

use common\models\UserData;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var common\models\UserDataSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Management';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
ul.archive-details
{
    padding-left:0;
}

ul.archive-details li
{
    /* padding-left:10px;
    padding-right: 10px; */
    width: 150px;
    font-style: italic;
    padding-top:10px;
}
</style>

<div class="user-data-index">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->

    <p>
        <?= Yii::$app->user->can('import-button-trainees') ? Html::a('<i class="fas fa-upload"></i> Import Trainees', ['import-trainees'], ['class' => 'btn btn-outline-success btn-sm']) : "" ?>
        <?= Yii::$app->user->can('create-button-trainee') ? Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' Trainee', ['create', 'account_type' => 'trainee'], ['class' => 'btn btn-outline-success btn-sm']) : "" ?>

        <?= Yii::$app->user->can('create-button-ojt-coordinator') ? Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' OJT Coordinator', ['create','account_type' => 'ojtcoordinator'], ['class' => 'btn btn-outline-success btn-sm']) : "" ?>

        <?= Yii::$app->user->can('create-button-company-supervisor') ?  Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' Company Supervisor', ['create','account_type' => 'companysupervisor'], ['class' => 'btn btn-outline-success btn-sm']) : "" ?>

        <?= Yii::$app->user->can('create-button-administrator') ? Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' Administrator', ['create','account_type' => 'administrator'], ['class' => 'btn btn-outline-primary btn-sm']) : "" ?>

        
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    


    <div style="margin-top:50px;">

        <div style="margin-bottom: 7.5px; margin-top:20px;">
        

        <?php 

        if(Yii::$app->user->can('access-trainee-index'))
        {
            echo Html::a('Trainees',['index', 'UserDataSearch[item_name]' => 'Trainee'],['class' => $searchModel->item_name == 'Trainee' || $searchModel->item_name == "" ? 'active-tab' : 'custom-tab']); 
        }
       
        if(Yii::$app->user->can('access-ojt-coordinator-index'))
        {
            echo Html::a('OJT Coordinators',['index', 'UserDataSearch[item_name]' => 'OjtCoordinator'],['class' => $searchModel->item_name == 'OjtCoordinator' ? 'active-tab' : 'custom-tab']);
        }
       
        if(Yii::$app->user->can('access-company-supervisor-index'))
        {
            echo Html::a('Company Supervisors',['index', 'UserDataSearch[item_name]' => 'CompanySupervisor'],['class' => $searchModel->item_name == 'CompanySupervisor' ? 'active-tab' : 'custom-tab']);
        }

        if(Yii::$app->user->can('access-administrator-index'))
        {
            echo Html::a('Administrators',['index', 'UserDataSearch[item_name]' => 'Administrator'],['class' => $searchModel->item_name == 'Administrator' ? 'active-tab' : 'custom-tab']) ;
        }
        
        
        ?>
        </div>

        <?php
            $actionButtons = "";

            if(Yii::$app->user->can("user-management-view"))
            {
                $actionButtons .= " {view} ";
            }

            if(Yii::$app->user->can("user-management-update"))
            {
                $actionButtons .= " {update} ";
            }

            if(Yii::$app->user->can("user-management-delete"))
            {
                $actionButtons .= " {delete} ";
            }
        ?>


        <div style="border:2px solid #ffdbdb; background:white;" class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => '{items}',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=> 'status',
                        'format' => 'raw',
                        'value' => function($model)
                        {
                            if(Yii::$app->user->can('user-management-update-status'))
                            {
                                $disp = "<ul class='archive-details'>";
                                $dataUserArchive = $model->userArchive;
                                if($dataUserArchive)
                                {
                                    foreach ($dataUserArchive as $arc) {
                                        $disp .= $arc->user_status == 10 ? "<li>DATE/TIME RESTORED: <br/>".(date('F j,Y h:i a',strtotime($arc->date_time)))."</li>": "<li>DATE/TIME ARCHIVED: <br/>".(date('F j,Y h:i a',strtotime($arc->date_time)))."</li>";
                                    }
                                }

                                $disp .= "</ul>";

                                return $model->status == 10 ? Html::a('ACTIVE',['update-status','id' => $model->id],[
                                    'class' => 'btn btn-success btn-sm',
                                    'data' => ['confirm' => 'Are you sure you want to DEACTIVATE this account?'],
                                    ]) : Html::a('INACTIVE',['update-status',
                                    'id' => $model->id,
                                ],[
                                    'class' => 'btn btn-secondary btn-sm',
                                    'data' => ['confirm' => 'Are you sure you want to ACTIVATE this account?'],
                                ]).$disp;
                            }
                            else
                            {
                                return $model->status == 10 ? "ACTIVE" : "INACTIVE";
                            }
                            
                        },
                        'filter' => [10 => 'ACTIVE', 9 => 'INACTIVE'],
                    ],
                    [
                        'label' => $searchModel->item_name == 'OjtCoordinator' ? 'Assigned Program/Course' : 'Program/Course',
                        'format' => 'raw',
                        
                        'attribute' => 'ref_program_id',
                        'value' => function ($model) {

                            $prom_val = "";
                            $updateProgram = "";
                            if(!empty($model->coordinatorPrograms))
                            {
                                $prom_val = "<ul>";
                                foreach ($model->coordinatorPrograms as $row) {
                                    $abbreviation = !empty($row->program->abbreviation) ? "[".$row->program->abbreviation."] " : "";
                                    $prom_val .= "<li style='color:#af4343;'>".$abbreviation." ".$row->program->title."</li>";
                                }
                                $prom_val .= "</ul>";

                                if($model->authAssignment->item_name == "OjtCoordinator")
                                {
                                    $updateProgram = Yii::$app->user->can('access-ojt-coordinator-index') ? " ".Html::a('<i class="fas fa-edit"></i>',['/coordinator-programs/index','CoordinatorProgramsSearch[user_id]' => $model->fname. " ". $model->mname. " ". $model->sname],['class' => 'btn btn-outline-primary btn-sm', 'style' => '', 'target' => '_blank'])." ".Html::button('<i class="fas fa-plus"></i>', ['value'=>Url::to('@web/coordinator-programs/ajax-create?user_id='.$model->id), 'class' => 'btn btn-outline-primary btn-sm modalButton','style' => 'border:none;']) : "";
                                }
                            }
                            else
                            {
                                if($model->authAssignment->item_name == "OjtCoordinator")
                                {
                                    $prom_val = Html::button('<i class="fas fa-plus"></i> Assign Program/Course', ['value'=>Url::to('@web/coordinator-programs/ajax-create?user_id='.$model->id), 'class' => 'btn btn-secondary btn-sm modalButton','style' => 'border:none;']);
                                }
                                else
                                {
                                    $abbreviation = !empty($model->program->abbreviation) ? $model->program->abbreviation : "";

                                    $prom_val = !empty($model->program->title) ? "<span style='color:#af4343; text-transform:uppercase;'>".$model->program->title." <strong>[".$abbreviation."]</strong></span>" : "";
                                }
                                
                            }
                            

                            return $prom_val.$updateProgram;
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\RefProgram::find()->asArray()->all(), 'id', 'title'),
                        // 'visible' => in_array($searchModel->item_name,['Trainee','OjtCoordinator',NULL,'']) ? true : false,
                        'visible' => Yii::$app->user->can('view-column-course-program') && in_array($searchModel->item_name,['Trainee','OjtCoordinator',NULL,'']),
                    ],
                    [
                        'attribute' => 'ref_program_major_id',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $abbreviation = !empty($model->programMajor->abbreviation) ? $model->programMajor->abbreviation : "";

                            return !empty($model->programMajor->title) ? "<span style='color:#af4343;'>".$model->programMajor->title." <strong>[".$abbreviation."]</strong> </span>" : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\ProgramMajor::find()->asArray()->all(), 'id', 'title'),
                        'visible' => in_array($searchModel->item_name,['Trainee',NULL,'']) ? true : false,
                    ],
                    [
                        'attribute' => 'student_year',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return !empty($model->student_year) ? "<span style='color:#af4343;'><strong>".$model->student_year."</strong> </span>" : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\StudentYear::find()->asArray()->all(), 'year', 'title'),
                        'visible' => in_array($searchModel->item_name,['Trainee',NULL,'']) ? true : false,
                        
                    ],
                    [
                        'attribute' => 'student_section',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return !empty($model->student_section) ? "<span style='color:#af4343;'><strong>".$model->student_section."</strong> </span>" : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\StudentSection::find()->asArray()->all(), 'section', 'section'),
                        'visible' => in_array($searchModel->item_name,['Trainee',NULL,'']) ? true : false,
                    ],
                    [
                        'attribute' => 'company',
                        'format' => 'raw',
                        'visible' => in_array($searchModel->item_name,['Trainee','CompanySupervisor',NULL,'']) ? true : false,
                        'value' => function ($model) {
                            return !empty($model->userCompany->company->name) ? "<span style='color:#af4343; text-transform:uppercase;'>".$model->userCompany->company->name."</span>" : "---";
                        },
                    ],
                    [
                        'attribute' => 'ref_department_id',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return !empty($model->department->title) ? "<span style='color:#af4343; font-style:italic;'>".$model->department->title."</span>" : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\Department::find()->asArray()->all(), 'id', 'title'),
                        'visible' => in_array($searchModel->item_name,['Trainee','CompanySupervisor',NULL,'']) ? true : false,
                    ],
                    [
                        'attribute' => 'student_idno',
                        'visible' => in_array($searchModel->item_name,['Trainee',NULL,'']) ? true : false,
                    ],
                    // 'fname',
                    [
                        'attribute' => 'fname',
                        'format' => 'raw',
                        'value' => function($model)
                        {
                            return !empty($model->fname) ? '<span style="font-size:14px; text-transform:uppercase;">'. $model->fname.'</span>' : "";
                        }
                    ],
                    [
                        'attribute' => 'mname',
                        'format' => 'raw',
                        'value' => function($model)
                        {
                            return !empty($model->mname) ? '<span style="font-size:14px; text-transform:uppercase;">'. $model->mname.'</span>' : "";
                        }
                    ],
                    [
                        'attribute' => 'sname',
                        'format' => 'raw',
                        'value' => function($model)
                        {
                            return !empty($model->sname) ? '<span style="font-size:14px; text-transform:uppercase;">'. $model->sname.'</span>' : "";
                        }
                    ],
                    [
                        'attribute' => 'suffix',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return !empty($model->suffix) ? '<span style="font-size:14px; text-transform:uppercase;">'.$model->suffix.'</span>' : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\Suffix::find()->asArray()->all(), 'title', 'title'),
                    ],
                    
                    // 'mname',
                    // 'sname',
                    'bday',
                    // [
                    //     'attribute' => 'bday',
                    //     'value' => function($model)
                    //     {
                    //         return Yii::$app->formatter->asDate($model->bday, 'MMM. d, Y');
                    //     }
                    // ],
                    [
                        'attribute' => 'sex',
                        'value' => function ($model) {
                            return $model->sex === 'M' ? 'Male' : 'Female';
                        },
                        'filter' => [
                            'M' => 'Male',
                            'F' => 'Female',
                        ],
                    ],
                    
                    [
                        'attribute' => 'ref_position_id',
                        'value' => function ($model) {
                            return !empty($model->position->position) ? $model->position->position : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\Position::find()->asArray()->all(), 'id', 'position'),
                        'visible' => in_array($searchModel->item_name,['CompanySupervisor']) ? true : false,
                    ],
                    'username',
                    //'auth_key',
                    //'password_hash',
                    //'password_reset_token',
                    'email:email',
                    'mobile_no',
                    'tel_no',
                    // 'status',
                    //'created_at',
                    //'updated_at',
                    //'verification_token',
                    'address',
                    [   
                        'format' => 'raw',
                        'label' => 'Has e-Signature?',
                        'visible' => !Yii::$app->user->can('upload-others-esig'),
                        'value' => function($model)
                        {
                            $buttons = "";
                            if(in_array($model->authAssignment->item_name,['CompanySupervisor','Trainee']))
                            {
                                $findFile = Yii::$app->getModule('admin')->FileExistsByQuery('UserData',$model->id);

                                if($findFile)
                                {
                                    $buttons .= "<span style='font-size:11px; color:white; background:#198754; padding-left:10px; padding-right:10px; border-radius:25px;'>YES</span>";
                                }
                                else
                                {
                                    $buttons .= "<span style='font-size:11px; color:white; background:gray; padding-left:10px; padding-right:10px; border-radius:25px;'>NO</span>";
                                }
                            }

                            return $buttons;
                            
                        }
                    ],
                    
                    // [
                    //     'class' => ActionColumn::className(),
                    //     'template' => $actionButtons,
                    //     'urlCreator' => function ($action, UserData $model, $key, $index, $column) {
                    //         return Url::toRoute([$action, 'id' => $model->id]);
                    //     }
                    // ],
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{regface} {timesheet} {esig} {view} {update} {delete}',
                        'buttons' => [
                            'regface' => function ($url, $model) {
                                if(Yii::$app->user->can('user-management-register-face'))
                                {
                                    if($model->authAssignment->item_name == "Trainee")
                                    {
                                        if(Yii::$app->getModule('admin')->haveFaceRegistered($model->id))
                                        {
                                            return Html::a('<i class="fas fa-pencil-alt"></i> Face',['register-face','user_id' => $model->id],['class' => 'btn btn-primary btn-sm','target' => '_blank']);
                                        }
                                        else
                                        {
                                            return Html::a('<i class="fas fa-plus"></i> Register Face',['register-face','user_id' => $model->id],['class' => 'btn btn-secondary btn-sm','target' => '_blank']);
                                        }
                                        
                                    }
                                }
                            },
                            'timesheet' => function ($url, $model) {
                                if(Yii::$app->user->can('view-other-timesheet'))
                                {
                                    if($model->authAssignment->item_name == "Trainee")
                                    {
                                        if(!empty($model->userTimesheet))
                                        {
                                            return Html::a('DTR',['/user-timesheet/index','trainee_user_id' => $model->id],['class' => 'btn btn-warning btn-sm','target' => '_blank']);
                                        }
                                    }
                                }
                            },
                            'esig' => function ($url, $model) {
                                $buttons = "";
                                if(in_array($model->authAssignment->item_name,['CompanySupervisor','Trainee']))
                                {
                                    $findFile = Yii::$app->getModule('admin')->FileExistsByQuery('UserData',$model->id);

                                    if($findFile)
                                    {
                                    $buttons .= Html::a('e-Sig',['upload-file','id' => $model->id,'message' => 'Signature'],['class' => 'btn btn-sm btn-outline-primary']);
                                    }
                                    else
                                    {
                                        $buttons .= Html::a('e-Sig',['upload-file','id' => $model->id],['class' => 'btn btn-sm btn-outline-secondary']);
                                    }
                                }

                                return Yii::$app->user->can('upload-others-esig') ? $buttons : false;
                            },
                            'view' => function ($url, $model) {
                                return Yii::$app->user->can('user-management-view') ? Html::a('View', $url, [
                                    'title' => Yii::t('yii', 'View'),
                                    'class' => 'btn btn-sm btn-outline-primary', // set the button class to outline-primary
                                ]) : false;
                            },
                            'update' => function ($url, $model) {
                                return Yii::$app->user->can('user-management-update') ?  Html::a('Edit', $url, [
                                    'title' => Yii::t('yii', 'Update'),
                                    'class' => 'btn btn-sm btn-outline-primary', // set the button class to outline-primary
                                ]) : false;
                            },
                            'delete' => function ($url, $model) {
                                if($model->status != 10)
                                {
                                    return Yii::$app->user->can('user-management-delete') ?  Html::a('Del', $url, [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'class' => 'btn btn-sm btn-outline-danger', // set the button class to outline-danger
                                        'data' => [
                                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],
                                    ]) : false;
                                }
                            },
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'view') {
                                $url = Url::to(['view', 'id' => $model->id]);
                                return $url;
                            } elseif ($action === 'update') {
                                $url = Url::to(['update', 'id' => $model->id]);
                                return $url;
                            } elseif ($action === 'delete') {
                                $url = Url::to(['delete', 'id' => $model->id]);
                                return $url;
                            }
                        },
                    ],
                    
                ],
            ]); ?>
        </div>
    </div>

</div>

<?php
echo LinkPager::widget([
    'pagination' => $dataProvider->pagination,
    'options' => [
        'class' => 'pagination justify-content-center', // add Bootstrap 5 classes to the pagination container
    ],
    'prevPageCssClass' => 'page-item',
    'nextPageCssClass' => 'page-item',
    'linkOptions' => [
        'class' => 'page-link', // add Bootstrap 5 classes to the pagination links
    ],
]);
?>

<?php
$this->registerJs('
    $("table").removeClass("table-bordered").addClass("table-hover");
');
?>
