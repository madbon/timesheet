
<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<h3>Date: <?= date('F j, Y',strtotime($date)) ?> / Time: <?= $formatted_time ?></h3>
<?php
    echo Html::img(Url::to(['preview-captured-photo', 'timesheet_id' => $timesheet_id, 'time' => $time]), [
        'alt'=>'My Image',
        'style' => 'width:100%;',
        'class' => 'img-responsive'
    ]);
?>