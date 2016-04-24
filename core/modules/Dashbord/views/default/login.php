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
                            <h4><p class="text-info">Login</p></h4>
                            <hr>
                        </div>
                        <div class="panel-body">

                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'login-form',
                                        'options' => ['class' => 'form-horizontal'],
                                        'fieldConfig' => [
                                            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                                            'labelOptions' => ['class' => 'col-lg-4 control-label'],
                                        ],
                            ]);
                            ?>

                            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                            <?= $form->field($model, 'password')->passwordInput() ?>
                            <?=
                            $form->field($model, 'captcha')->widget(yii\captcha\Captcha::className(), [
                                'captchaAction' => '/site/captcha',
                                'template' => '<div class="row"><div class="col-lg-6">{input}</div></div><div class = "row"><div class="col-lg-3">{image}</div></div>',
                            ])
                            ?>  


                            <div class="form-group">
                                <div class="col-lg-12 text-center">
                                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                </div>
                            </div>

                            <?php ActiveForm::end(); ?>

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

