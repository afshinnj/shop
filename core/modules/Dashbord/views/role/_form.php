<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-4">
        <div class="role-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        </div>

    </div>
    <div class="col-md-8">
        <?php
        $roles = $model->getAllRoles();
        foreach ($roles as $k => $v):
            ?>
            <!-- Begin Panel-->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?= $k ?>
                    </div>
                </div>

                <div class="panel-body">
                    <?php
                    foreach ($v as $item) {
                        echo yii\bootstrap\Html::checkbox("Items[{$item['name']}]", $item['checked'], ['label' => $item['label']]);
                    }
                    ?>
                </div>

                <div class="panel-footer"></div>
            </div>
            <!-- End Panel-->
        <?php endforeach; ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
