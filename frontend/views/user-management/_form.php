<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\UserData $model */
/** @var yii\widgets\ActiveForm $form */
?>
<style>
    i.asterisk
    {
        color:red;
        font-size:20px;
        font-weight: bold;
    }
</style>

<div class="user-data-form">

    <?php
        $astCompany = '<i class="asterisk">*</i>';
        $astDepartment = '<i class="asterisk">*</i>';
        $astPosition = '<i class="asterisk">*</i>';
        $astStudentID = '<i class="asterisk">*</i>';
        $astProgram = '<i class="asterisk">*</i>';
        $astMajor = '<i class="asterisk">*</i>';
        $astYear = '<i class="asterisk">*</i>';
        $astSection = '<i class="asterisk">*</i>';
        $astBday = '<i class="asterisk">*</i>';
        $astSex = '<i class="asterisk">*</i>';
        $astAddress = '<i class="asterisk">*</i>';
        $astMobile = '<i class="asterisk">*</i>';
        $astTelephone = '<i class="asterisk">*</i>';
        $astEmail = '<i class="asterisk">*</i>';
        $astUsername = '<i class="asterisk">*</i>';
        $astPassword = '<i class="asterisk">*</i>';
        $astFirstname = '<i class="asterisk">*</i>';
        $astLastname = '<i class="asterisk">*</i>';
        $astRole = '<i class="asterisk">*</i>';

        if($model->item_name == "Trainee")
        {
            if(!Yii::$app->user->can('Trainee'))
            {
                $astPosition = "";
                $astCompany = "";
                $astDepartment = "";
                $astProgram = "";
                $astMajor = "";
                $astYear = "";
                $astSection = "";
                $astBday = "";
                $astSex = "";
                $astAddress = "";
                $astMobile = "";
                $astTelephone = "";
                $astUsername = "";
                $astPassword = "";

            }
            else
            {
                
            }
        }
        else if($model->item_name == "OjtCoordinator")
        {
            if(!Yii::$app->user->can('OjtCoordinator'))
            {
                $astBday = "";
                $astSex = "";
                $astAddress = "";
                $astMobile = "";
                $astTelephone = "";
                $astUsername = "";
                $astPassword = "";
            }
            else
            {

            }
        }
        else if($model->item_name == "CompanySupervisor")
        {
            if(!Yii::$app->user->can('CompanySupervisor'))
            {
                $astDepartment = "";
                $astPosition = "";
                $astBday = "";
                $astSex = "";
                $astAddress = "";
                $astMobile = "";
                $astTelephone = "";
                $astUsername = "";
                $astPassword = "";
            }
            else
            {
                
            }
        }
        else if($model->item_name == "Administrator")
        {
            $astDepartment = "";
            $astPosition = "";
            $astBday = "";
            $astSex = "";
            $astAddress = "";
            $astMobile = "";
            $astTelephone = "";
            $astUsername = "";
            $astPassword = "";
        }
    ?>

    <span style="background:#e3ffe3; color:black; border-radius:5px; padding:5px; font-size:12px;"><i class="fas fa-exclamation-circle" style="color:green;"></i> All fields with asterisk(<i class="asterisk">*</i>) are required. Please provide necessary information.</span><br/><br/>

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
                // ['prompt'=>'Select option']
            )->label('Role'.($astRole)) ?>
            </div>
        </div>
    <?php } ?>

    <div class="card" style="<?= in_array($account_type,['administrator','ojtcoordinator']) ? 'display:none;' : 'margin-bottom: 10px;'; ?>" >
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

            
            <?= $form->field($model, 'company')->dropDownList($company, ['prompt' => '-NOTHING SELECTED-','class' => 'form-control'])->label("Company".($astCompany)." ".(Yii::$app->user->can('access-company-supervisor-index') ? '<code style="font-size:10px;">If company is not on the list </code>'.Html::a('<i class="fas fa-plus"></i> ADD COMPANY',['/company/index'],['style' => 'font-size:10px; text-decoration:none;', 'target' => '_blank']) : '')) ?>

            
            <div class="row" style="margin-top: 10px;">
                <?php if(in_array($account_type,['companysupervisor','trainee'])){ ?>
                <div class="col-sm-6">
                    <!-- <label>Department</label> -->
                    <?= $form->field($model, 'ref_department_id')->dropDownList($department, [
                        'prompt' => '-NOTHING SELECTED-',
                        'class' => 'form-control',
                        // 'enableAjaxValidation' => true, // Enable Ajax validation for this field
                    ])->label('Department'.($astDepartment)) ?>
                </div>
                <?php } ?>
                <?php if(in_array($account_type,['companysupervisor'])){ ?>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'ref_position_id')->dropDownList($position, ['prompt' => '-NOTHING SELECTED-', 'class' => 'form-control'])->label('Position'.($astPosition)) ?>
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
                            echo $form->field($model, 'student_idno')->textInput(['maxlength' => true])->label('Student ID'.($astStudentID));;
                        }
                    ?>
                </div>
            </div>
            
            <?php if(in_array($account_type,['trainee'])){ ?>
            <div class="row">
                <div class="col-sm-4">
                    <?php 
                        // if(in_array($account_type,['trainee']))
                        // {
                            echo $form->field($model, 'ref_program_id')->dropDownList(
                                $program,
                                [
                                    'prompt' => '-NOTHING SELECTED-',
                                    'onchange' => '
                                        $.post("' . Yii::$app->urlManager->createUrl('/admin/default/get-major?program_id=') . '" + $(this).val(), function(data) {
                                            $("#' . Html::getInputId($model, 'ref_program_major_id') . '").html(data);
                                        });
                                    '
                                ]
                            )->label('Program/Course'.($astProgram));
                        // }
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php     
                        // if(in_array($account_type,['trainee']))
                        // {
                            echo $form->field($model, 'ref_program_major_id')->dropDownList(
                                !empty($major) ? $major : [],
                                ['prompt'=>'Select Program/Course First']
                            )->label('Course Major'.($astMajor));
                        // }
                    ?>
                </div>
            </div>   
            <?php } ?>

            <div class="row">
                <div class="col-sm-4">
                    <?php 
                        if(in_array($account_type,['trainee']))
                        {
                            echo $form->field($model, 'student_year')->dropDownList(
                                $student_year,
                                ['prompt'=>'-NOTHING SELECTED-']
                            )->label('Year'.($astYear));;
                        }
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php 
                        if(in_array($account_type,['trainee']))
                        {
                            echo $form->field($model, 'student_section')->dropDownList(
                                $student_section,
                                ['prompt'=>'-NOTHING SELECTED-']
                            )->label('Section'.($astSection));; 
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
                    <?= $form->field($model, 'fname')->textInput(['maxlength' => true])->label('First Name'.($astFirstname)); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'sname')->textInput()->label('Last Name'.($astLastname)); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'suffix')->dropDownList(
                        $suffix,
                        ['prompt'=>'-NOTHING SELECTED-']
                    ) ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-3" style=<?= in_array($model->item_name,['OjtCoordinator','CompanySupervisor','Administrator']) ? 'display:none;' : ''  ?> >
                    <?= $form->field($model, 'bday')->textInput(['type' => 'date', 'max' => (date('Y') - 18).date('-m-d')])->label('Birth Date'.($astBday)); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'sex')->dropDownList(
                        ['M' => 'Male', 'F' => 'Female'],
                        ['prompt'=>'-NOTHING SELECTED-']
                    )->label('Sex'.($astSex)); ?>
                </div>
                
            </div>

            <div class="row">
                <div class="col-sm-12" style=<?= in_array($model->item_name,['OjtCoordinator','CompanySupervisor','Administrator']) ? 'display:none;' : ''  ?> >
                    <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label("Complete Address <i>(House Block/Lot No, Street Name, Subdivision/Village, Barangay, City/Municipality, Province, Zip Code)</i>".($astAddress)); ?>
                </div>
            </div>  
        </div>
    </div>

    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <h5 class="card-title">Contact Information</h5>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => 10, 'placeholder' => '+63 9123456789'])->label('Mobile No.'.($astMobile)) ?>
                        
                    </div>
                    <div class="col-sm-4" style=<?= in_array($model->item_name,['OjtCoordinator','Trainee','Administrator']) ? 'display:none;' : ''  ?> >
                        <?= $form->field($model, 'tel_no')->textInput(['maxlength' => true])->label('Telephone No.'.($astTelephone)) ?>
                    </div>
                </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Login Credentials</h5>
            <div class="row">
                <div class="col-sm-5">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Email'.($astEmail)) ?>
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Username'.($astUsername).(Yii::$app->controller->action->id == 'create' ? ' <code style="font-size:10px;">NOTE: The system will generate a username if you leave it blank.</code>' : '')) ?>
                    <?= $form->field($model, 'password')->textInput(['maxlength' => true])->label('Password'.(Yii::$app->controller->action->id == 'create' ? ' <code style="font-size:10px;">NOTE: The system will generate a password if you leave it blank.</code>' : '')) ?>
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

<?php
if(in_array($model->item_name,["Trainee","OjtCoordinator","Administrator"]) && Yii::$app->controller->action->id == "create")
{
    $js = <<< JS
        $(document).ready(function() {
            $('#userdata-fname, #userdata-mname, #userdata-sname').on('input', function() {
                var firstName = $('#userdata-fname').val().trim();
                var middleName = $('#userdata-mname').val().trim();
                var lastName = $('#userdata-sname').val().trim().replace(/\s+/g, '');
                var emailPrefix = getInitials(firstName) + getInitials(middleName) + lastName.toLowerCase();
                $('#userdata-email').val(emailPrefix + '@bpsu.edu.ph');
            });
        });

        function getInitials(name) {
            var initials = '';
            var words = name.split(' ');
            for (var i = 0; i < words.length; i++) {
                var word = words[i];
                if (word.length > 0) {
                    initials += word.charAt(0);
                }
            }
            return initials.toLowerCase();
        }
    JS;

    $this->registerJs($js);
}
?>
