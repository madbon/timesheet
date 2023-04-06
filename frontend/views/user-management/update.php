<?php

use yii\helpers\Html;
use common\models\CoordinatorPrograms;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\UserData $model */

$this->title = 'Update User Account: ' . $model->fullName();
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index','UserDataSearch[item_name]' => 'Trainee']];
$this->params['breadcrumbs'][] = ['label' => "Account Details: ".$model->fullName(), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        $account_type =NULL;
        switch ($model->authAssignment->item_name) {
            case 'Trainee':
               $account_type = "trainee";
            break;
            case 'OjtCoordinator':
                $account_type = "ojtcoordinator";
            break;
            case 'CompanySupervisor':
                $account_type = "companysupervisor";
            break;
            case 'Administrator':
                $account_type = "administrator";
            break;
            
            default:
                # code...
            break;
        }
    ?>

<?php if($model->authAssignment->item_name == "OjtCoordinator"){ ?>
        <?php if(CoordinatorPrograms::find()->where(['user_id' => $model->id])->exists()){ ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="card" style="margin-bottom:10px;">
                    
                    <div class="card-body">
                        <h5>Assigned Program(s)/Course(s) <?= Html::a('<i class="fas fa-edit"></i>',['/coordinator-programs/index','CoordinatorProgramsSearch[user_id]' => $model->fname. " ". $model->mname. " ". $model->sname],['class' => 'btn btn-outline-primary', 'style' => 'float:right;', 'target' => '_blank']) ?></h5>
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

    <?= $this->render('_form', [
        'model' => $model,
        'roleArr' => $roleArr,
        'suffix' => $suffix,
        'student_section' => $student_section,
        'student_year' => $student_year,
        'program' => $program,
        'major' => $major,
        'account_type' => $account_type,
        'position' => $position,
            'department' => $department,
            'company' => $company,
    ]) ?>

</div>
