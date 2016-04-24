<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Dashbord\models\Categorys */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categorys-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'shop_id')->dropDownList(app\modules\Shop\models\Shop::Dropdown()) ?>
    <?= $form->field($model, 'group')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
