<?php

namespace app\modules\Dashbord\controllers;

use Yii;
use app\modules\Dashbord\models\Categorys;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Categorys model.
 */
class CategoryController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionAjax() {
        $shop_id = Yii::$app->request->post('shop_id');
        $category = \app\modules\Dashbord\models\Categorys::findAll(['shop_id' => $shop_id, 'state' => Categorys::$GROUP_STATE]);
        foreach ($category as $row) {
            echo '<option value="' . $row->id . '">' . $row->group . '</option>';
        }
    }

    /**
     * Lists all Categorys models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Categorys::find()->where(['user_id' => Yii::$app->user->id, 'state' => Categorys::$CATEGORY_STATE]),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Categorys model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Categorys();
        $model->scenario = 'category';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/category']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Categorys model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->scenario = 'category';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/category']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Categorys model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Categorys model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categorys the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Categorys::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
