<?php

use common\models\EvaluationForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\EvaluationFormSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Evaluation Form: '.$traineeName;
$this->params['breadcrumbs'][] = ['label' => 'Evaluation Forms', 'url' => ['/user-management/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evaluation-form-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('Create Evaluation Form', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-responsive table-bordered'],
                // 'filterModel' => $searchModel,
                'columns' => [
                    // ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    // 'submission_thread_id',
                    // 'trainee_user_id',
                    // [
                    //     'label' => 'Trainee',
                    //     'value' => function($model)
                    //     {
                    //         return $model->traineeUser->userFullNameWithMiddleInitial;
                    //     }
                    // ],
                    // 'user_id',
                    // 'date_commenced',
                    // 'date_complete',
                    // 'evaluation_criteria_id',
                    [
                        'label' => 'Criteria',
                        'value' => function($model)
                        {
                            return $model->evaluationCriteria->title;
                        }
                    ],
                    [
                        'label' => 'Max Points',
                        'value' => function($model)
                        {
                            return $model->evaluationCriteria->max_points;
                        }
                    ],
                    [
                        'label' => 'Points Scored',
                        'value' => function($model)
                        {
                            return !empty($model->points_scored) ? $model->points_scored : NULL;
                        }
                    ],
                    [
                        'label' => 'Remarks',
                        'value' => function($model)
                        {
                            return !empty($model->remarks) ? $model->remarks : NULL;
                        }
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::button('<i class="fas fa-edit"></i> Score', ['value'=>Url::to('@web/evaluation-form/update?id='.$model->id), 'class' => 'btn btn-warning btn-sm modalButton','style' => 'border:none;']);
                            },
                        ],
                        'urlCreator' => function ($action, EvaluationForm $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <div style="text-align: right;">
    <?= Html::a('Proceed to Submission <i class="fas fa-arrow-right"></i>',['/submission-thread/create','ref_document_type_id' => 1,'from_eval_form' => 'yes', 'trainee_user_id' => $trainee_user_id],['class' => 'btn btn-success', 'style' => 'margin-top:20px;']); ?>
    </div>
</div>
