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

    <br/>
    <button id="copy-company-details" type="button" class="btn btn-outline-dark">LOAD COMPANY DETAILS</button>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    
    <?php
        $this->registerJs('
            $("#copy-company-details").click(function(){
                var companyName = $("#company_name").val();
                var companyAddress = $("#address").val();
                var companyLat = $("#latitude").val();
                var companyLong = $("#longitude").val();

                $("#company-name").val(companyName);
                $("#company-address").val(companyAddress);
                $("#company-latitude").val(companyLat);
                $("#company-longitude").val(companyLong);

                $("#label-latitude").text(companyLat);
                $("#label-longitude").text(companyLong);
                
            });
        ')
    ?>

</div>
