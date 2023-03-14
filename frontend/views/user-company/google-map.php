<?php
use yii\helpers\Html;

$this->title = 'MAP THE COMPANY';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-google-map">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $content ?>
</div>
