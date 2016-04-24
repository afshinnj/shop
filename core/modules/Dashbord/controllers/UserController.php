<?php

namespace app\modules\Dashbord\controllers;

use Yii;
use app\modules\Dashbord\models\User;
use app\modules\Dashbord\models\Role;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'signup', 'index', 'create', 'update', 'delete', 'view', 'password'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup', 'index', 'password', 'update', 'delete', 'view'],
                        'roles' => ['user', 'admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                //'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        if (Yii::$app->user->can('admin')) {
            $dataProvider = new ActiveDataProvider([
                'query' => User::find(),
            ]);
        }

        if (Yii::$app->user->can('user')) {
            $dataProvider = new ActiveDataProvider([
                'query' => User::find()->where(['id' => Yii::$app->user->id]),
            ]);
        }
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User();
        $role = new Role();
        $POST_VARIABLE = Yii::$app->request->post('User');
        if ($model->load(Yii::$app->request->post())) {

            $model->role_id = $POST_VARIABLE['role_id'];
            $model->save();
            $model->save_assignment("$model->id", $POST_VARIABLE['role_id']);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'dropDown' => $role->dropdown(),
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * 
     * @return mixed
     */
    public function actionUpdate() {

        $POST_VARIABLE = Yii::$app->request->post('User');
        $auth_key = Yii::$app->request->post('auth_key');

        if (isset($auth_key)) {
            Yii::$app->session['auth_key'] = Yii::$app->request->post('auth_key');
        }

        $model = $this->findModel(Yii::$app->session['auth_key']);


        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->user->can('admin')) {
                $model->role_id = $POST_VARIABLE['role_id'];
            }

            $model->save();

            if (Yii::$app->user->can('admin')) {
                $model->save_assignment("$model->id", $POST_VARIABLE['role_id']);
            }
            Yii::$app->session->setFlash("Account-success", Yii::t("app", "Account updated"));
            return $this->refresh();
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * user
     * action Cheang Password
     */
    public function actionPassword() {
        $auth_key = Yii::$app->request->post('auth_key');

        if (isset($auth_key)) {
            Yii::$app->session['auth_key'] = Yii::$app->request->post('auth_key');
        }

        $user = $this->findModel(Yii::$app->session['auth_key']);

        $user->setScenario('reset');
        $loadedPost = $user->load(Yii::$app->request->post());
        if ($loadedPost) {
            $user->save(FALSE);
            Yii::$app->session->setFlash("Account-success", Yii::t("app", "Account updated"));
            return $this->refresh();
        }

        return $this->render('password', ['model' => $user]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete() {

        if (!Yii::$app->user->can('admin')) {
            $user_id = Yii::$app->user->id;
            $model = $this->findModel($this->auth_key)->delete();
        } else {
            $auth_key = Yii::$app->request->post('auth_key');

            if (!isset($auth_key)) {
                $POST_VARIABLE = Yii::$app->request->post('User');
                $auth_key = $POST_VARIABLE['auth_key'];
            }
            $user = $this->findModel($$auth_key);
            $user_id = $user['id'];
            $model = $this->findModel($auth_key)->delete();
        }

        $rule = new \app\modules\User\models\AuthAssignment();
        $rule->deleteAll(['user_id' => $user_id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne(['auth_key' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
