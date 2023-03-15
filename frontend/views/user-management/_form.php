<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\UserData $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-data-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php if(Yii::$app->controller->action->id == "update"){ ?>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-sm-3">
            <?= $form->field($model, 'item_name')->dropDownList(
                $roleArr,
                ['prompt'=>'Select option']
            ) ?>
            </div>
        </div>
    <?php } ?>

    <div class="card" style="margin-bottom:10px;">
        <div class="card-body">
        
            <h5 class="card-title">Personal Information</h5>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'sname')->textInput() ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'suffix')->dropDownList(
                        $suffix,
                        ['prompt'=>'Select option']
                    ) ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'bday')->textInput(['type' => 'date', 'max' => (date('Y') - 18).date('-m-d')]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'sex')->dropDownList(
                        ['M' => 'Male', 'F' => 'Female'],
                        ['prompt'=>'Select option']
                    ) ?>
                </div>
                
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label("Complete Address <i>(House Block/Lot No, Street Name, Subdivision/Village, Barangay, City/Municipality, Province, Zip Code)</i>"); ?>
                </div>
            </div>  
        </div>
    </div>

    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <h5 class="card-title">
                <?php
                    switch ($account_type) {
                        case 'trainee':
                            echo "Student Information";
                        break;
                        case 'ojtcoordinator':
                            echo "Assigned Program/Course";
                        break;
                        case 'companysupervisor':
                            echo "Company and Assigned Department/Position";
                        break;
                        
                        default:
                            # code...
                        break;
                    }
                ?>
            </h5>
            <div class="row">
                <div class="col-sm-4">
                    <?php 
                        if($account_type == "trainee")
                        {
                            echo $form->field($model, 'student_idno')->textInput(['maxlength' => true]);
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?php 
                        if(in_array($account_type,['trainee','ojtcoordinator']))
                        {
                            echo $form->field($model, 'ref_program_id')->dropDownList(
                                $program,
                                [
                                    'prompt' => '-- PROGRAM/COURSE --',
                                    'onchange' => '
                                        $.post("' . Yii::$app->urlManager->createUrl('/admin/default/get-major?program_id=') . '" + $(this).val(), function(data) {
                                            $("#' . Html::getInputId($model, 'ref_program_major_id') . '").html(data);
                                        });
                                    '
                                ]
                                    );
                        }
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php     
                        if(in_array($account_type,['trainee']))
                        {
                            echo $form->field($model, 'ref_program_major_id')->dropDownList(
                                !empty($major) ? $major : [],
                                ['prompt'=>'Select Program/Course First']
                            );
                        }
                    ?>
                </div>
            </div>   
            <div class="row">
                <div class="col-sm-4">
                    <?php 
                        if(in_array($account_type,['trainee']))
                        {
                            echo $form->field($model, 'student_year')->dropDownList(
                                $student_year,
                                ['prompt'=>'Select option']
                            );
                        }
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php 
                        if(in_array($account_type,['trainee']))
                        {
                            echo $form->field($model, 'student_section')->dropDownList(
                                $student_section,
                                ['prompt'=>'Select option']
                            ); 
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <?php 
                if(Yii::$app->controller->action->id == "update")
                {
                    echo !empty($model->userCompany->company->name) ? $model->userCompany->company->name : "NO COMPANY";
                }
            ?>
            <h5 class="card-title">Tag the Company</h5>
            <?= $form->field($model, 'company')->dropDownList([], ['prompt' => 'Select a company', 'id' => 'company-dropdown','class' => 'form-control'])->label(false) ?>

            <?php
            // JavaScript
            $script = <<< JS
            $(function() {
                var timer;
                var delay = 500; // 500 milliseconds delay after last input

                function fetchCompanies(query, callback) {
                    $.ajax({
                        url: "company-json",
                        dataType: "json",
                        data: {
                            q: query.term
                        },
                        success: function(data) {
                            var results = [];
                            $.each(data, function(index, item) {
                                results.push({
                                    id: item.id,
                                    text: item.name + ' (ADDRESS: ' +item.address+')'
                                });
                            });

                            callback({
                                results: results
                            });
                        }
                    });
                }

                $('#company-dropdown').select2({
                    placeholder: 'Search for a company',
                    minimumInputLength: 3,
                    ajax: {
                        delay: delay,
                        transport: function(params, success, failure) {
                            clearTimeout(timer);
                            timer = setTimeout(function() {
                                fetchCompanies(params.data, success);
                            }, delay);
                        }
                    }
                });
            });
            JS;

            $this->registerJs($script);
            ?>
        </div>
    </div>

    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <h5 class="card-title">Contact Information</h5>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true, 'placeholder' => '+63 9123456789']) ?>
                        
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'tel_no')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Login Credentials</h5>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
                    <?php // $form->field($model, 'confirm_password')->textInput(['maxlength' => true]) ?>
                </div>
            </div>   
        </div>
    </div>

    <div class="form-group" style="margin-top: 10px;">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
