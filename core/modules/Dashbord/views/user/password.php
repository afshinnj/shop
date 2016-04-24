<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'Cheang Password';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <?php if (Yii::$app->session->getFlash("Account-success")): ?>

        <div class="alert alert-success">
            <p><?= Yii::$app->session->getFlash("Account-success") ?></p>
        </div>

    <?php elseif (Yii::$app->session->getFlash("Account-Unsuccessful")): ?>

        <div class="alert alert-success">
            <p><?= Yii::$app->session->getFlash("Account-Unsuccessful") ?></p>
        </div>

    <?php elseif (Yii::$app->session->getFlash("Cancel-success")): ?>

        <div class="alert alert-success">
            <p><?= Yii::$app->session->getFlash("Cancel-success") ?></p>
        </div>

    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'auth_key', ['options' => ['value' => Yii::$app->user->identity['auth_key']]])->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'old_password')->textInput(['maxlength' => true]) ?>
    <hr>
    <?= $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'repeat_password')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
