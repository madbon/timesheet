<?php

use yii\helpers\Html;
use common\models\CoordinatorPrograms;

/** @var yii\web\View $this */
/** @var common\models\UserData $model */

$this->title = 'My Account';
// $this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index','UserDataSearch[item_name]' => 'Trainee']];
// $this->params['breadcrumbs'][] = ['label' => "Account Details", 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
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

    <?php if(CoordinatorPrograms::find()->where(['user_id' => Yii::$app->user->identity->id])->exists()){ ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="card" style="margin-bottom:10px;">
                
                <div class="card-body">
                    <h5>Assigned Program(s)/Course(s)</h5>
                    <table class="table table-hover">
                        <tbody>
                            <?php
                                $query = CoordinatorPrograms::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
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

<?php

?>


</div>
