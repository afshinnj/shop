<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\User\models\Role;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'Update User: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">
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

    <?= $form->field($model, 'auth_key', ['options' => ['value' => Yii::$app->user->identity['auth_key']]])->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?php if (Yii::$app->user->can('admin')): ?>
        <?= $form->field($model, 'role_id')->dropDownList(ArrayHelper::map(Role::find()->where(['type' => 1])->All(), 'name', 'name'), ['id' => 'auth_item']); ?>
<?php endif; ?>

    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
