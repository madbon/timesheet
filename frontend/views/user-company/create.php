<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserCompany $model */

$this->title = 'Create User Company';
$this->params['breadcrumbs'][] = ['label' => 'User Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-company-create">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->

    <?= $this->render('google-map', [
            'content' => $googleMap,
        ]);
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?php
        $this->registerJs('
            $(".container-fluid").mousemove(function(){
                var companyName = $("#company_name").val();
                var companyAddress = $("#address").val();
                var companyLat = $("#latitude").val();
                var companyLong = $("#longitude").val();
                var companyContact = $("#contact_info").val();

                $("input#usercompany-name").val(companyName);
                $("input#usercompany-address").val(companyAddress);
                $("input#usercompany-latitude").val(companyLat);
                $("input#usercompany-longitude").val(companyLong);
                $("input#usercompany-contact_info").val(companyContact);
                
            });
        ')
    ?>


</div>
