<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\EvaluationForm;

/** @var yii\web\View $this */
/** @var common\models\SubmissionThread $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="submission-thread-form">

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'enableAjaxValidation' => Yii::$app->controller->action->id == "create" ? true : false,
    ]) ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'ref_document_type_id')->dropDownList($documentType, ['prompt' => 'Select transaction type', 'class' => 'form-control', 'disabled' => true])->label("Type of Action") ?>

            <?php if(Yii::$app->getModule('admin')->documentTypeAttrib(Yii::$app->request->get('ref_document_type_id'),'enable_tagging')){ ?>

                <?php if($from_eval_form == 'yes'){ ?>
                    <?= $form->field($model, 'tagged_user_id')->hiddenInput()->label(false) ?>
                    
                <?php }else{ ?>
                    
                    <?= $form->field($model, 'tagged_user_id')->dropDownList(yii\helpers\ArrayHelper::map(\common\models\UserData::find()->select(['user.id','CONCAT(fname," ", mname," ", sname) as fname'])
                ->joinWith('authAssignment')
                ->joinWith('userCompany')
                ->joinWith('evaluationForm')
                ->where(['auth_assignment.item_name' => 'Trainee'])
                ->andWhere(['user.status' => 10])
                ->andWhere(['user.ref_department_id' => Yii::$app->getModule('admin')->GetAssignedDepartment()])
                ->andWhere(['user_company.ref_company_id' => Yii::$app->getModule('admin')->GetAssignedCompany()])
                ->andWhere(['evaluation_form.submission_thread_id' => NULL])
                ->andWhere(['NOT',['evaluation_form.trainee_user_id' => NULL]])
                ->andWhere(['NOT',['evaluation_form.points_scored' => NULL]])
                ->andFilterWhere(['user.id' => $trainee_user_id])
                ->groupBy(['user.id'])
                ->all(),'id','fname'), ['prompt' => 'Select Trainee..', 'class' => 'form-control'])->label("Trainee") ?>
                <?php } ?>

            <?php } ?>

            <?php if($model->ref_document_type_id == 1){ ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'date_commenced')->textInput(['type' => 'date', 'max' => date('Y-m-d')])->label('Date Commenced'); ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'date_completed')->textInput(['type' => 'date', 'max' => date('Y-m-d')])->label('Date Completed'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php  // $form->field($model, 'subject')->textInput() ?>

            <?= $form->field($model, 'remarks')->textarea(['rows' => 3])->label($model->ref_document_type_id == 1 ? "Comments/Recommendations for the trainee's further growth" : "Remarks") ?>

            

            <div style="border:2px solid #ddd; padding:10px; margin-top:15px; background:white; border-radius:5px;">
                <p>
                    <code><strong>Acccepted File format:</strong> png, jpg, jpeg, gif, pdf, docx, xlsx, xls</code><br/>
                    <code><strong>Max file size:</strong> Less than 5MB</code><br/>
                    <code><strong>Max no. of files per upload:</strong> 5 files</code>
                </p>
                <hr>
                <?= $form->field($modelUpload, 'imageFiles[]')->fileInput(['multiple' => true])->label(false) ?>
            </div>

            <?php // $form->field($model, 'ref_document_type_id')->textInput() ?>

            <?php // $form->field($model, 'created_at')->textInput() ?>

            <div class="form-group">
                <?php 
                    if(Yii::$app->controller->action->id == 'create')
                    {
                        echo Html::submitButton($from_eval_form == 'yes' ? 'Submit <i class="fas fa-paper-plane"></i>' : Yii::$app->controller->action->id, ['class' => 'btn btn-warning']); 
                    }
                    else
                    {
                        echo Html::submitButton('<i class="fas fa-check"></i> Update ', ['class' => 'btn btn-warning']); 
                    }
                ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <?php if($from_eval_form == 'yes'){ ?>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Evaluation <?= Yii::$app->controller->action->id == "create" ? Html::a('<i class="fas fa-edit"></i>',['/evaluation-form/index','trainee_user_id' => $trainee_user_id]) : "" ?></h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Criteria</th>
                                    <th>Max Points</th>
                                    <th>Points Scored</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $evalForm = EvaluationForm::find()->where(['trainee_user_id' => $trainee_user_id])->all();
                                $totalPoints = 0;
                                foreach ($evalForm as $eval) { 
                                    $totalPoints += $eval->points_scored;
                                    ?>
                                    <tr>
                                        <td><?= $eval->evaluationCriteria->title ?></td>
                                        <td><?= $eval->evaluationCriteria->max_points ?></td>
                                        <td><?= $eval->points_scored ?></td>
                                        <td><?= $eval->remarks ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <h5>Total Score: <?= $totalPoints ?> points</h5>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

   

</div>
