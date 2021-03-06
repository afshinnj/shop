<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Item');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorys-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'shop_name',
                'value' => function($model) {
            $shopName = app\modules\Shop\models\Shop::findOne(['shop_id' => $model->shop_id]);
            return $shopName['name'];
        }
            ],
            [
                'attribute' => 'Group',
                'value' => function($model) {
            $s = app\modules\Dashbord\models\Categorys::findOne(['id' => $model->group_id]);
            return $s['group'];
        }
            ],
            [
                'attribute' => 'Category',
                'value' => function($model) {
            $s = app\modules\Dashbord\models\Categorys::findOne(['id' => $model->category_id]);
            return $s['category'];
        }
            ],
            'item',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
