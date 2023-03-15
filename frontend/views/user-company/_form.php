<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var common\models\UserCompany $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-company-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Search Input -->
<!-- <input id="company-search" type="text" class="form-control" placeholder="Search for a company ..." /> -->

<!-- Dropdown Input -->
<?php // $form->field($model, 'ref_company_id')->dropDownList([], ['prompt' => 'Select a company'])->label(false) ?>

<?= $form->field($model, 'ref_company_id')->dropDownList([], ['prompt' => 'Select a company', 'id' => 'company-dropdown','class' => 'form-control'])->label(false) ?>

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

<?php
// // JavaScript
// $script = <<< JS
// $(function() {
//     var timer;
//     var delay = 500; // 500 milliseconds delay after last input

//     function fetchCompanies(query) {
//         $.ajax({
//             // url: "{Url::to(['company/company-json'])}",
//             url: "company-json",
//             dataType: "json",
//             data: {
//                 q: query
//             },
//             success: function(data) {
//                 var options = '<option value>Select a company</option>';
//                 $.each(data, function(index, item) {
//                     options += '<option value="' + item.name + '">' + item.name +' ('+ item.address +')</option>';
//                 });

//                 $('#usercompany-ref_company_id').html(options);
//             }
//         });
//     }

//     $('#usercompany-ref_company_id').on('click',function(){
//         fetchCompanies(null);
//     });

//     // $('#company-search').on('input', function() {
//     //     clearTimeout(timer);
//     //     var query = $(this).val();

//     //     if (query.length >= 3) {
//     //         timer = setTimeout(function() {
//     //             fetchCompanies(query);
//     //         }, delay);
//     //     }
//     // });
// });
// JS;

// $this->registerJs($script);
?>


    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_info')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
