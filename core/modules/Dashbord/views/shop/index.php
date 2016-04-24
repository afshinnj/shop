<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Shops');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Shop'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'shop_id',
            'user_id',
            'title',
            'name',
            // 'email:email',
            // 'tel',
            // 'description:ntext',
            // 'status',
            // 'create_time',
            // 'update_time',
            // 'ban_time',
            // 'ban_reason',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
