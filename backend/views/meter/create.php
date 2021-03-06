<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Meter */

$this->title = Yii::t('app', 'Add Meter');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Meters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'addresses' => $addresses,
    ]) ?>

</div>
