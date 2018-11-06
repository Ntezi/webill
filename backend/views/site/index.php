<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name;
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t('app', 'Dashboard') ?></h1>
    </div>

    <div class="col-lg-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
//            'user_id',
//            'bill_info_id',
//            'previous_reading',
                'current_reading',
                //'image_path',
                //'bill_file_path',
                'total_amount',
//            'verified_by_user',
//            'verified_by_admin',
                'created_at',
                //'created_by',
                //'updated_by',
                //'updated_at',
                'deadline',
                'paid_flag',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{check} {approve} {reject}',
                    'buttons' => [

                        'check' => function ($url, $model) {
                            //if ($model->verified_by_user == Yii::$app->params['verified_no'])
                            return Html::a(Html::tag('i', Yii::t('app', ' Check'), ['class' => 'fa fa-edit']), ['bill/index', 'id' => $model->id],
                                ['class' => 'btn btn-primary btn-xs']);
                        },
                        'approve' => function ($url, $model) {
                            //if ($model->verified_by_user == Yii::$app->params['verified_no'])
                            return Html::a(Html::tag('i', Yii::t('app', ' Approve'), ['class' => 'fa fa-thumbs-up']), $url, [
                                'class' => 'btn btn-success btn-xs',
                                'data' => [
                                    'confirm' => Yii::t('app', '\'Are you sure you want to approve this information?'),
                                    'method' => 'post',
                                ],
                            ]);
                        },
                        'reject' => function ($url, $model) {
                            //if ($model->verified_by_user == Yii::$app->params['verified_no'])
                            return Html::a(Html::tag('i', Yii::t('app', ' Reject'), ['class' => 'fa fa-trash']), $url, [
                                'class' => 'btn btn-danger btn-xs',
                                'data' => [
                                    'confirm' => Yii::t('app', '\'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]);
                        },

                    ],],
            ],
        ]); ?>
    </div>

</div>