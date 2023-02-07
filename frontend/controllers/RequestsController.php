<?php

namespace frontend\controllers;

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
     $searchModel = new RequestsSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            $dataProvider->query->andFilterWhere(['client'=>Yii::$app->getUser()->identity->client]);
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
      
    }


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
