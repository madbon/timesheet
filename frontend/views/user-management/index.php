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

<div class="user-data-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::$app->user->can('create-button-trainee') ? Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' Trainee', ['create', 'account_type' => 'trainee'], ['class' => 'btn btn-success']) : "" ?>

        <?= Yii::$app->user->can('create-button-ojt-coordinator') ? Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' OJT Coordinator', ['create','account_type' => 'ojtcoordinator'], ['class' => 'btn btn-success']) : "" ?>

        <?= Yii::$app->user->can('create-button-company-supervisor') ?  Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' Company Supervisor', ['create','account_type' => 'companysupervisor'], ['class' => 'btn btn-success']) : "" ?>

        <?= Yii::$app->user->can('create-button-administrator') ? Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' Administrator', ['create','account_type' => 'administrator'], ['class' => 'btn btn-outline-primary']) : "" ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    


    <div style="margin-top:50px;">

        <div style="margin-bottom: 8px; margin-top:20px;">
        

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


        <div style="border:2px solid #ddd;  padding:5px;" class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => '{items}',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'item_name',
                        'label' => 'ROLE',
                        'format' => 'raw',
                        'visible' => Yii::$app->user->can('user-management-delete-role-assigned'),
                        'value' => function($model)
                        {

                            if(!empty($model->authAssignment->itemName->name))
                            {
                                if($model->authAssignment->itemName->name == "Administrator")
                                {
                                    return Html::a(($model->authAssignment->itemName->name),['delete-role-assigned','user_id' => $model->id],[
                                        'class' => 'btn btn-sm btn-outline-primary',
                                        'data' => ['confirm' => 'Are you sure you want to remove the assigned role? Click OK to perform action.'],
                                    ]);
                                }
                                else
                                {
                                    return Html::a(($model->authAssignment->itemName->name),['delete-role-assigned','user_id' => $model->id],[
                                        'class' => 'btn btn-sm btn-outline-success',
                                        'data' => ['confirm' => 'Are you sure you want to remove the assigned role? Click OK to perform action.'],
                                    ]);
                                }
                                
                            }
                            else
                            {
                                return '<span style="color:red;">NO ASSIGNED ROLE</span>';
                            }

                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\AuthItem::find()->where(['type' => 1])->asArray()->all(), 'name', 'name'),
                    ],
                    [
                        'label' => $searchModel->item_name == 'OjtCoordinator' ? 'Assigned Program/Course' : 'Program/Course',
                        'attribute' => 'ref_program_id',
                        'value' => function ($model) {
                            return !empty($model->program->title) ? $model->program->title : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\RefProgram::find()->asArray()->all(), 'id', 'title'),
                        'visible' => in_array($searchModel->item_name,['Trainee','OjtCoordinator',NULL,'']) ? true : false,
                    ],
                    [
                        'attribute' => 'ref_program_major_id',
                        'value' => function ($model) {
                            return !empty($model->programMajor->title) ? $model->programMajor->title : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\ProgramMajor::find()->asArray()->all(), 'id', 'title'),
                        'visible' => in_array($searchModel->item_name,['Trainee',NULL,'']) ? true : false,
                    ],
                    [
                        'attribute' => 'student_year',
                        'value' => function ($model) {
                            return !empty($model->student_year) ? $model->student_year : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\StudentYear::find()->asArray()->all(), 'year', 'title'),
                        'visible' => in_array($searchModel->item_name,['Trainee',NULL,'']) ? true : false,
                        
                    ],
                    [
                        'attribute' => 'student_section',
                        'value' => function ($model) {
                            return !empty($model->student_section) ? $model->student_section : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\StudentSection::find()->asArray()->all(), 'section', 'section'),
                        'visible' => in_array($searchModel->item_name,['Trainee',NULL,'']) ? true : false,
                    ],
                    [
                        'attribute' => 'student_idno',
                        'visible' => in_array($searchModel->item_name,['Trainee',NULL,'']) ? true : false,
                    ],
                    'fname',
                    
                    'mname',
                    'sname',
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
                        'attribute' => 'suffix',
                        'value' => function ($model) {
                            return !empty($model->suffix) ? $model->suffix : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\Suffix::find()->asArray()->all(), 'title', 'title'),
                    ],
                    [
                        'attribute' => 'company',
                        'format' => 'raw',
                        'visible' => in_array($searchModel->item_name,['Trainee','CompanySupervisor',NULL,'']) ? true : false,
                        'value' => function ($model) {
                            return !empty($model->userCompany->company->name) ? "<i style='color:blue;'>".$model->userCompany->company->name."</i>" : "<i style='color:red; font-weight:bold;'>---</i>";
                        },
                    ],
                    [
                        'attribute' => 'ref_department_id',
                        'value' => function ($model) {
                            return !empty($model->department->title) ? $model->department->title : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\Department::find()->asArray()->all(), 'id', 'title'),
                        'visible' => in_array($searchModel->item_name,['Trainee','CompanySupervisor',NULL,'']) ? true : false,
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
                        'label' => 'Actions',
                        'value' => function($model)
                        {
                            $buttons = "";
                            if(in_array($model->authAssignment->item_name,['CompanySupervisor','Trainee']))
                            {
                                $findFile = Yii::$app->getModule('admin')->FileExistsByQuery('UserData',$model->id);

                                if($findFile)
                                {
                                    $buttons .= Html::a((Yii::$app->getModule('admin')->GetIcon('upload-cloud')),['upload-file','id' => $model->id,'message' => 'Signature'],['class' => 'btn btn-sm btn-outline-primary']);
                                }
                                else
                                {
                                    $buttons .= Html::a((Yii::$app->getModule('admin')->GetIcon('upload-cloud')),['upload-file','id' => $model->id],['class' => 'btn btn-sm btn-outline-secondary']);
                                }
                                
                            }

                            return $buttons;
                            
                        }
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'template' => $actionButtons,
                        'urlCreator' => function ($action, UserData $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
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
