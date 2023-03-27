<?php
use Johnson\JayWebcam;

$this->title = 'Capture Photo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-capture-photo">
    <h1><?= $this->title ?></h1>
    <?= JayWebcam::widget() ?>
    <form method="post" action="<?= Yii::$app->urlManager->createUrl(['site/capture-photo']) ?>">
        <button type="submit" class="btn btn-primary">Capture Photo</button>
    </form>
</div>