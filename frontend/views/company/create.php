<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Company $model */

$this->title = 'Create Company';
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-create">

    <h1><?= Html::encode($this->title) ?></h1>

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

                $("input#company-name").val(companyName);
                $("input#company-address").val(companyAddress);
                $("input#company-latitude").val(companyLat);
                $("input#company-longitude").val(companyLong);
                $("input#company-contact_info").val(companyContact);
                
            });
        ')
    ?>

</div>
