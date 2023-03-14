<?php
use yii\helpers\Html;

$this->title = 'Companies Map Markers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-google-map">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $content ?>
</div>
