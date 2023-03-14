<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserCompany $model */

$this->title = 'Create User Company';
$this->params['breadcrumbs'][] = ['label' => 'User Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
