<?php

namespace app\modules\Shop\controllers;

use Yii;
use app\modules\Shop\models\Details;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DetailsController implements the CRUD actions for Details model.
 */
class DetailsValueController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [ 'index', 'create', 'update', 'delete', 'view'],
                        'roles' => ['user'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Details models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Details::find()->where(['user_id'=>Yii::$app->user->id , 'state'=> Details::$DETAIL]),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Details model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Details();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/details']);
        } else {
            return $this->render('_detailsCreate', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Details model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/details']);
        } else {
            return $this->render('_detailsUpdate', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Details model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Details model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Details the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Details::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 
     * 
     */
    public function actionItems() {
        $dataProvider = new ActiveDataProvider([
            'query' => Details::find()->where(['user_id'=>Yii::$app->user->id , 'state'=> Details::$ITEM]),
        ]);

        return $this->render('itemIndex', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionItemupdate($id) {
        $model = $this->findModel($id);
        $model->scenario = 'ItemCreate';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/items']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionItemcreate() {
        $model = new Details();
        $model->scenario = 'ItemCreate';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/items']);
        } else {
            return $this->render('_itemCreate', [
                        'model' => $model,
            ]);
        }
    }

    public function actionItemdelete() {
        
    }

    /**
     * 
     * 
     */
    public function actionValueupdate() {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/details']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionValuecreate() {
        $model = new Details();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/details']);
        } else {
            return $this->render('_detailsCreate', [
                        'model' => $model,
            ]);
        }
    }

    public function actionValuedelete() {
        
    }

}
