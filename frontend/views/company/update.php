<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Company $model */

$this->title = 'Update Company: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-update">

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

                if(companyName == "" || companyAddress == "" || companyLat == "" || companyLong == "")
                {

                }
                else
                {
                    $("#company-name").val(companyName);
                    $("#company-address").val(companyAddress);
                    $("#company-latitude").val(companyLat);
                    $("#company-longitude").val(companyLong);

                    $("#label-latitude").text(companyLat);
                    $("#label-longitude").text(companyLong);
                }
            });
        ')
    ?>

</div>
