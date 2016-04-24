<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="details-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Items'), ['itemcreate'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'shop_name',
                'value' => function($model) {
                    $s = app\modules\Shop\models\Shop::findOne(['shop_id' => $model->shop_id]);
                    return $s['name'];
                }
                    ],
                    [
                        'attribute' => 'Details',
                        'value' => function($model) {
                            $s = app\modules\Shop\models\Details::findOne(['id' => $model->title_id]);
                            return $s['title'];
                        }
                            ],
                            'item',
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>

</div>
