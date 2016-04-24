<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'shop_name',
                'value' => function($model) {
                    $s= app\modules\Shop\models\Shop::findOne(['shop_id'=>$model->shop_id]);
                    return $s['name'];
                }
            ],
            [
                'attribute' => 'item_id',
                'value' => function($model) {
                    $s= app\modules\Dashbord\models\Item::findOne(['id'=>$model->item_id]);
                    return $s['name'];
                }
            ],
            'title',
            // 'description:ntext',
            // 'detail',
            // 'create_time',
            // 'update_time',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
