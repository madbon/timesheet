<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SystemOtherFeature $model */

$this->title = 'Create System Other Feature';
$this->params['breadcrumbs'][] = ['label' => 'System Other Features', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-other-feature-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
