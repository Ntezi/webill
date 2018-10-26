<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bills');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Upload Image'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'bill_info_id',
            'previous_reading',
            'current_reading',
            //'image_path',
            //'bill_file_path',
            //'total_amount',
            //'verified_by_user',
            //'verified_by_admin',
            //'created_at',
            //'created_by',
            //'updated_by',
            //'updated_at',
            //'deadline',
            //'paid_flag',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
