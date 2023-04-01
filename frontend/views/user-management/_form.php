<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\UserData $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-data-form">

    <?php $form = ActiveForm::begin([
        'id' => 'user-management-form',
        'enableAjaxValidation' => Yii::$app->controller->action->id == "create" ? true : false,
        // ... other options ...
    ]); ?>
    
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

    <div class="card" style="<?= $account_type == "administrator" ? 'display:none;' : 'margin-bottom: 10px;'; ?>" >
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
            <!-- LINK THE COMPANY -->
            <?php if(in_array($account_type,['trainee','companysupervisor'])){ ?>
            <!-- <div class="card" style="margin-bottom: 10px;">
                <div class="card-body"> -->
                    <?php 
                        // if(Yii::$app->controller->action->id == "update")
                        // {
                        //     if(!empty($model->userCompany->company->name))
                        //     {
                        //         echo "This User is in this Company: 
                        //         <p><code><strong>Name: </strong>".$model->userCompany->company->name."</code><br/>
                        //         <code><strong>Address: </strong>".$model->userCompany->company->address."</code><br/>
                        //         <code><strong>Contact Info: </strong>".$model->userCompany->company->contact_info."</code>
                        //         </p>
                        //         ";
                        //     }
                        // }
            ?>
            
            <p style="display:none;">
                <code><strong>Note #1: </strong> If the company is not found in the search box, encode the company details in the list. <?= Html::a('CLICK HERE',['/company/create'],['target' => '_blank']) ?> to add the company.</code> <br/>
                <code><strong>Note #2: </strong> If you have already encoded the company in the list, try again to search for it in the search box. </code>
            </p>

            <?= $form->field($model, 'company')->dropDownList($company, ['prompt' => 'Select a company','class' => 'form-control'])->label("Company") ?>

            
            <div class="row" style="margin-top: 10px;">
                <?php if(in_array($account_type,['companysupervisor','trainee'])){ ?>
                <div class="col-sm-6">
                    <label>Department</label>
                    <?= $form->field($model, 'ref_department_id')->dropDownList($department, [
                        'prompt' => 'Select Department',
                        'class' => 'form-control',
                        // 'enableAjaxValidation' => true, // Enable Ajax validation for this field
                    ])->label(false) ?>
                </div>
                <?php } ?>
                <?php if(in_array($account_type,['companysupervisor'])){ ?>
                    <div class="col-sm-6">
                        <label>Position</label>
                        <?= $form->field($model, 'ref_position_id')->dropDownList($position, ['prompt' => 'Select Position', 'class' => 'form-control'])->label(false) ?>
                    </div>
                <?php } ?>
            </div>
            

            <?php
            // JavaScript
            // $script = <<< JS
            // $(function() {
            //     var timer;
            //     var delay = 500; // 500 milliseconds delay after last input

            //     function fetchCompanies(query, callback) {
            //         $.ajax({
            //             url: "company-json",
            //             dataType: "json",
            //             data: {
            //                 q: query.term
            //             },
            //             success: function(data) {
            //                 var results = [];
            //                 $.each(data, function(index, item) {
            //                     results.push({
            //                         id: item.id,
            //                         text: item.name + ' (ADDRESS: ' +item.address+')'
            //                     });
            //                 });

            //                 callback({
            //                     results: results
            //                 });
            //             }
            //         });
            //     }

            //     $('#company-dropdown').select2({
            //         placeholder: 'Search company',
            //         minimumInputLength: 3,
            //         ajax: {
            //             delay: delay,
            //             transport: function(params, success, failure) {
            //                 clearTimeout(timer);
            //                 timer = setTimeout(function() {
            //                     fetchCompanies(params.data, success);
            //                 }, delay);
            //             }
            //         }
            //     });
            // });
            // JS;

            // $this->registerJs($script);
            ?>
        <!-- </div>
    </div> -->
    <?php } ?>
            <!-- LINK THE COMPANY END-->
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
            <h5 class="card-title">Contact Information</h5>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => 10, 'placeholder' => '+63 9123456789']) ?>
                        
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
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'type' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
