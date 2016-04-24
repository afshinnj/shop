<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (Yii::$app->user->can('admin')) {
            echo Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'username',
            'email:email',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {pass}',
                'buttons' => [
                    'pass' => function ($url, $model) {
                         return Html::beginForm(['/password'], 'post') .
                          Html::hiddenInput('auth_key', $model['auth_key']) .
                          Html::submitButton(
                          '<span class="glyphicon glyphicon-lock"></span>', ['class' => 'btn btn-link']
                          ) .
                          Html::endForm(); 

                    }, //password btn end
                            'update' => function ($url, $model) {
                        return Html::beginForm(['/update'], 'post') .
                                Html::hiddenInput('auth_key', $model['auth_key']) .
                                Html::submitButton(
                                        '<span class="glyphicon glyphicon-pencil"></span>', ['class' => 'btn btn-link']
                                ) .
                                Html::endForm();
                    }, //update btn end
                            'delete' => function ($url, $model) {
                        return Html::beginForm(['/delete'], 'post') .
                                Html::hiddenInput('auth_key', $model['auth_key']) .
                                Html::submitButton(
                                        '<span class="glyphicon glyphicon-trash"></span>', ['class' => 'btn btn-link']
                                ) .
                                Html::endForm();
                    }, //delete btn end
                        ]
                    ],
                ],
            ]);
            ?>

</div>
