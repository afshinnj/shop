<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="signUpBody">
        <?php $this->beginBody() ?>

        <div class="wrap">
            <div class="container singupContiner">
                <div class="col-lg-4"></div>

                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <?= yii\bootstrap\Html::img('@web/images/avatar.png', ['alt' => 'Avatar', 'class' => 'avatar', 'width' => '50px']); ?> 
                            <h4><p class="text-info">SignUp</p></h4>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <?php $form = ActiveForm::begin(); ?>

                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'passwordConfirm')->passwordInput(['maxlength' => true]) ?>

                            <?=
                            $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::classname(), [
                                    // configure additional widget properties here
                            ])
                            ?>
                            <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                        <div class="panel-body text-center signUpFooter">
<?= Html::a(Yii::t('app', 'Login'), 'login') ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4"></div>

            </div>
        </div>

<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
