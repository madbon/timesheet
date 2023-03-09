<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserData $model */

$this->title = "Account Details: ".$model->fullName();
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'label' => 'ROLE',
                'format' => 'raw',
                'value' => function($model)
                {
                    return !empty($model->roleAssignment->cmsRole->title) ? '<span style="padding-left:10px; padding-right:10px; border-radius:5px; color:white; background:#6262ff;">'.$model->roleAssignment->cmsRole->title.'</span>' : '<span style="color:red;">NO ASSIGNED ROLE</span>';
                }
            ],
            'fname',
            'mname',
            'sname',
            'bday',
            'sex',
            'username',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'verification_token',
        ],
    ]) ?>

</div>
