<?php

namespace app\modules\Frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\modules\Shop\models\Shop;
use app\modules\Dashbord\models\User;
use app\modules\Dashbord\models\Group;

class DefaultController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor' => 0xF5F5F5, // background color
                'foreColor' => 0x000000, // font color
                'transparent' => true, // background transparent
                'testLimit' => 1, // how many times should the same CAPTCHA be displayed
                'minLength' => 6, // min length of generated word
                'maxLength' => 6, // max length of generated word
                'width' => 150, // width of the CAPTCHA image
                'height' => 65, // height of the CAPTCHA image
                'offset' => -1, // space between characters
                'padding' => 4 // padding around the text
            ],
        ];
    }

    public function actionIndex() {
        $shop = new Shop();
        $user = new User();

        $shops = $shop->findAll(['status' => 1]);
        $users = $user->findAll(['status' => 1]);

        return $this->render('index', ['shops' => $shops, 'users' => $users]);
    }

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    public function actionAbout() {
        return $this->render('about');
    }

    public function actionShop() {

        $id = Yii::$app->request->get('id');
        $shop = new Shop();
        $shops = $shop->findOne(['id' => $id]);
        $group = Group::findAll(['shop_id' => $shops['shop_id']]);



        return $this->render('shop', ['shop' => $shops, 'group' => $group]);
    }

}
