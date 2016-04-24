<?php

namespace app\modules\Dashbord\controllers;

use Yii;
use yii\web\Controller;
use app\modules\Dashbord\models\LoginForm;
use app\modules\Dashbord\models\User;

class DefaultController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'yii\web\CaptchaAction',
                'fixedVerifyCode' => YII_ENV === 'test' ? 'testme' : null,
            ),
        );
    }

    public function actionLogin() {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            //return $this->goBack();
            return $this->redirect('Dashbord');
        }
        return $this->renderPartial('login', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        $session_id = Yii::$app->session->getId();
        Yii::$app->session->destroySession($session_id);
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup() {

        $model = new User();
        $model->scenario = 'signUp';
        if ($model->load(Yii::$app->request->post())) {
            $model->role_id = 'user';
            $model->save();
            $model->save_assignment("$model->id", 'user');
            $this->redirect('login');
        }


        return $this->renderPartial('signup', ['model' => $model]);
    }

}
