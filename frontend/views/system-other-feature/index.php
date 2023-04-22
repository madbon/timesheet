<?php

use common\models\SystemOtherFeature;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\SystemOtherFeatureSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'System Other Features';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-other-feature-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create System Other Feature', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'feature',
            // 'enabled',
            [
                'attribute' => 'enabled',
                'value' => function($model)
                {
                    return $model->enabled ? "YES" : "NO";
                },
                'filter' => [1 => 'YES', 0 => 'NO'],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SystemOtherFeature $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
