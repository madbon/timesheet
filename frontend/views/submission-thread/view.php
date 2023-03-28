<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\SubmissionThread $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Details";
\yii\web\YiiAsset::register($this);
?>
<div class="submission-thread-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>

    <?php 
    // DetailView::widget([
    //     'model' => $model,
    //     'attributes' => [
    //         'id',
    //         'user_id',
    //         'remarks:ntext',
    //         'ref_document_type_id',
    //         'created_at',
    //     ],
    // ]) 
    ?>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($files as $file): ?>
                    <tr>
                        <td><?= Html::encode($file->file_name . '.' . $file->extension) ?></td>
                        <td>
                            <?php if (in_array($file->extension, ['png', 'jpg', 'jpeg', 'gif', 'pdf'])): ?>
                                <?= Html::a('Preview', Url::to(['preview', 'id' => $file->id]), ['class' => 'btn btn-info', 'target' => '_blank']) ?>
                            <?php endif; ?>
                            <?= Html::a('Download', Url::to(['download', 'id' => $file->id]), ['class' => 'btn btn-primary']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
