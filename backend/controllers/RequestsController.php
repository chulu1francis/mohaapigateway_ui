<?php

namespace backend\controllers;

use backend\models\Requests;
use backend\models\RequestsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use Yii;
use backend\models\User;

/**
 * RequestsController implements the CRUD actions for Requests model.
 */
class RequestsController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['index'],
                        'rules' => [
                            [
                                'actions' => ['index'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                        ],
                    ],
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'delete' => ['POST'],
                        ],
                    ],
                ]
        );
    }

    /**
     * Lists all Requests models.
     *
     * @return string
     */
    public function actionIndex() {
        if (User::isUserAllowedTo("View requests")) {
            $searchModel = new RequestsSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            if (!empty(Yii::$app->request->queryParams['RequestsSearch']['created_at'])) {
                $dateArray = explode(" to ", Yii::$app->request->queryParams['RequestsSearch']['created_at']);

                $dataProvider->query->andFilterWhere(['between', 'date(created_at)', $dateArray[0], $dateArray[1]]);
            }

            $dataProvider->pagination = ['pageSize' => 15];

            $dataProvider->setSort([
                'attributes' => [
                    'created_at' => [
                        'desc' => ['created_at' => SORT_DESC],
                        'default' => SORT_DESC
                    ],
                ],
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ]);
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Displays a single Requests model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionView($id) {
//        if (User::isUserAllowedTo("View requests")) {
//            return $this->render('view', [
//                        'model' => $this->findModel($id),
//            ]);
//        } else {
//            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
//            return $this->redirect(['home/index']);
//        }
//    }

    /**
     * Finds the Requests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Requests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Requests::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
