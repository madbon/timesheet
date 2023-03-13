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
        <?= Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' Trainee', ['create', 'account_type' => 'trainee'], ['class' => 'btn btn-success']) ?>
        <?= Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' OJT Coordinator', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' Company Supervisor', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a((Yii::$app->getModule('admin')->GetIcon('person-plus-fill')).' Administrator', ['create'], ['class' => 'btn btn-outline-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    


    <div style="margin-top:50px;">

        <div style="margin-bottom: 8px; margin-top:20px;">
        <?= Html::a('Trainees',['index', 'UserDataSearch[item_name]' => 'Trainee'],['class' => $searchModel->item_name == 'Trainee' ? 'active-tab' : 'custom-tab']) ?>
        <?= Html::a('OJT Coordinators',['index', 'UserDataSearch[item_name]' => 'OjtCoordinator'],['class' => $searchModel->item_name == 'OjtCoordinator' ? 'active-tab' : 'custom-tab']) ?>
        <?= Html::a('Company Supervisors',['index', 'UserDataSearch[item_name]' => 'CompanySupervisor'],['class' => $searchModel->item_name == 'CompanySupervisor' ? 'active-tab' : 'custom-tab']) ?>
        <?= Html::a('Administrators',['index', 'UserDataSearch[item_name]' => 'Administrator'],['class' => $searchModel->item_name == 'Administrator' ? 'active-tab' : 'custom-tab']) ?>
        </div>


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
                        'value' => function($model)
                        {
                            // return !empty($model->roleAssignment->cmsRole->title) ? '<span style="padding-left:10px; padding-right:10px; border-radius:5px; color:white; background:#6262ff;">'.$model->roleAssignment->cmsRole->title.'</span>' : '<span style="color:red;">NO ASSIGNED ROLE</span>';

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
                    // [
                    //     'label' => 'Program/Course',
                    //     'attribute' => 'program.title',
                    // ],
                    [
                        'attribute' => 'ref_program_id',
                        'value' => function ($model) {
                            return !empty($model->program->title) ? $model->program->title : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\RefProgram::find()->asArray()->all(), 'id', 'title'),
                    ],
                    [
                        'attribute' => 'ref_program_major_id',
                        'value' => function ($model) {
                            return !empty($model->programMajor->title) ? $model->programMajor->title : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\ProgramMajor::find()->asArray()->all(), 'id', 'title'),
                    ],
                    'student_idno',
                    [
                        'attribute' => 'student_year',
                        'value' => function ($model) {
                            return !empty($model->student_year) ? $model->student_year : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\StudentYear::find()->asArray()->all(), 'year', 'title'),
                    ],
                    [
                        'attribute' => 'student_section',
                        'value' => function ($model) {
                            return !empty($model->student_section) ? $model->student_section : "";
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\StudentSection::find()->asArray()->all(), 'section', 'section'),
                    ],
                    // 'student_year',
                    // 'student_section',
                    // 'id',
                    'fname',
                    // 'roleAssignment.cmsRole.title',
                    
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
                    'suffix',
                    'username',
                    //'auth_key',
                    //'password_hash',
                    //'password_reset_token',
                    'email:email',
                    // 'status',
                    //'created_at',
                    //'updated_at',
                    //'verification_token',
                    [
                        'format' => 'raw',
                        'label' => 'Upload',
                        'value' => function($model)
                        {

                            $findFile = Yii::$app->getModule('admin')->FileExistsByQuery('UserData',$model->id);

                            return $findFile ? Html::a((Yii::$app->getModule('admin')->GetIcon('upload-cloud')).' Update Signature',['upload-file','id' => $model->id,'message' => 'Update Signature'],['class' => 'btn btn-sm btn-outline-primary']) : Html::a((Yii::$app->getModule('admin')->GetIcon('upload-cloud')).' Upload Signature',['upload-file','id' => $model->id],['class' => 'btn btn-sm btn-outline-secondary']);
                        }
                    ],
                    [
                        'class' => ActionColumn::className(),
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
