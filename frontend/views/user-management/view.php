<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use common\models\CoordinatorPrograms;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\UserData $model */

$this->title = "Account Details: ".$model->fullName();
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index','UserDataSearch[item_name]' => 'Trainee']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php if($model->authAssignment->item_name == "OjtCoordinator"){ ?>
        <?php if(CoordinatorPrograms::find()->where(['user_id' => $model->id])->exists()){ ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="card" style="margin-bottom:10px;">
                    
                    <div class="card-body">
                        <h5>Assigned Program(s)/Course(s) <?= $updateProgram = Yii::$app->user->can('access-ojt-coordinator-index') ? " ".Html::a('<i class="fas fa-edit"></i>',['/coordinator-programs/index','CoordinatorProgramsSearch[user_id]' => $model->fname. " ". $model->mname. " ". $model->sname],['class' => 'btn btn-outline-primary btn-sm', 'style' => 'float:right;', 'target' => '_blank']) : ""; ?></h5>
                        <table class="table table-hover">
                            <tbody>
                                <?php
                                    $query = CoordinatorPrograms::find()->where(['user_id' => $model->id])->all();
                                    foreach ($query as $row) {
                                        $major = !empty($row->program->abbreviation) ? "[".$row->program->abbreviation."] " : "";
                                        echo "
                                            <tr>
                                                <td><code> * </code> ".$major." ".(!empty($row->program->title) ? $row->program->title : "")."</td>
                                            </tr>
                                        ";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php }else{ ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card" style="margin-bottom:10px;">
                        
                        <div class="card-body">
                            <h5>Assigned Program(s)/Course(s):
                                <?= Html::button('<i class="fas fa-plus"></i> ASSIGN', ['value'=> Url::to('@web/coordinator-programs/ajax-create?user_id='.$model->id), 'class' => 'btn btn-secondary btn-sm modalButton','style' => 'border:none;']) ?>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'label' => 'ROLE',
                'format' => 'raw',
                'value' => function($model)
                {
                    return !empty($model->authAssignment->itemName->name) ? '<span style="padding-left:10px; padding-right:10px; border-radius:5px; color:white; background:#6262ff;">'.$model->authAssignment->itemName->name.'</span>' : '<span style="color:red;">NO ASSIGNED ROLE</span>';
                }
            ],
            [
                'label' => $model->authAssignment->item_name == 'OjtCoordinator' ? 'Assigned Program/Course' : 'Program/Course',
                'format' => 'raw',
                'attribute' => 'ref_program_id',
                'value' => function ($model) {
                    return !empty($model->program->title) ? "<span style='color:#af4343; text-transform:uppercase;'>".$model->program->title."</span>" : "";
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\RefProgram::find()->asArray()->all(), 'id', 'title'),
                'visible' => in_array($model->authAssignment->item_name,['Trainee','OjtCoordinator',NULL,'']) ? true : false,
            ],
            [
                'attribute' => 'ref_program_major_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return !empty($model->programMajor->title) ? "<span style='color:#af4343;'>".$model->programMajor->title."</span>" : "";
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\ProgramMajor::find()->asArray()->all(), 'id', 'title'),
                'visible' => in_array($model->authAssignment->item_name,['Trainee',NULL,'']) ? true : false,
            ],
            [
                'attribute' => 'student_year',
                'value' => function ($model) {
                    return !empty($model->student_year) ? $model->student_year : "";
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\StudentYear::find()->asArray()->all(), 'year', 'title'),
                'visible' => in_array($model->authAssignment->item_name,['Trainee',NULL,'']) ? true : false,
                
            ],
            [
                'attribute' => 'student_section',
                'value' => function ($model) {
                    return !empty($model->student_section) ? $model->student_section : "";
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\StudentSection::find()->asArray()->all(), 'section', 'section'),
                'visible' => in_array($model->authAssignment->item_name,['Trainee',NULL,'']) ? true : false,
            ],
            [
                'attribute' => 'company',
                'format' => 'raw',
                'visible' => in_array($model->authAssignment->item_name,['Trainee','CompanySupervisor',NULL,'']) ? true : false,
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
                'visible' => in_array($model->authAssignment->item_name,['Trainee','CompanySupervisor',NULL,'']) ? true : false,
            ],
            [
                'attribute' => 'student_idno',
                'visible' => in_array($model->authAssignment->item_name,['Trainee',NULL,'']) ? true : false,
            ],
            // 'fname',
            [
                'attribute' => 'fname',
                'format' => 'raw',
                'value' => function($model)
                {
                    return !empty($model->fname) ? '<span style=" text-transform:uppercase;">'. $model->fname.'</span>' : "";
                }
            ],
            [
                'attribute' => 'mname',
                'format' => 'raw',
                'value' => function($model)
                {
                    return !empty($model->mname) ? '<span style=" text-transform:uppercase;">'. $model->mname.'</span>' : "";
                }
            ],
            [
                'attribute' => 'sname',
                'format' => 'raw',
                'value' => function($model)
                {
                    return !empty($model->sname) ? '<span style=" text-transform:uppercase;">'. $model->sname.'</span>' : "";
                }
            ],
            [
                'attribute' => 'suffix',
                'format' => 'raw',
                'value' => function ($model) {
                    return !empty($model->suffix) ? '<span style=" text-transform:uppercase;">'.$model->suffix.'</span>' : "";
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\Suffix::find()->asArray()->all(), 'title', 'title'),
            ],
            
            // 'mname',
            // 'sname',
            // 'bday',
            [
                'attribute' => 'bday',
                'value' => function($model)
                {
                    return Yii::$app->formatter->asDate($model->bday, 'MMMM j, Y');
                }
            ],
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
                'visible' => in_array($model->authAssignment->item_name,['CompanySupervisor']) ? true : false,
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
        ],
    ]) ?>

</div>
