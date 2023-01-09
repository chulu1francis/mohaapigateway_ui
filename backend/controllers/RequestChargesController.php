<?php

namespace backend\controllers;

use backend\models\RequestCharges;
use backend\models\RequestChargesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use Yii;
use backend\models\User;

/**
 * RequestChargesController implements the CRUD actions for RequestCharges model.
 */
class RequestChargesController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['index', 'delete', 'create'],
                        'rules' => [
                            [
                                'actions' => ['index', 'delete', 'create'],
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
     * Lists all RequestCharges models.
     *
     * @return string
     */
    public function actionIndex() {
        if (User::isUserAllowedTo("Manage request charges") ||
                User::isUserAllowedTo("View request charges")) {

            $searchModel = new RequestChargesSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            if (Yii::$app->request->post('hasEditable')) {
                $userId = Yii::$app->request->post('editableKey');
                $model = RequestCharges::findOne($userId);
                $out = Json::encode(['output' => '', 'message' => '']);
                $posted = current($_POST['RequestCharges']);
                $post = ['RequestCharges' => $posted];

                if ($model->load($post)) {
                    $model->updated_by = Yii::$app->user->id;
                    $model->save(false);
                    $output = '';
                    $out = Json::encode(['output' => $output, 'message' => '']);
                }
                return $out;
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
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    public function actionCreate() {
        if (User::isUserAllowedTo("Manage request charges")) {
            $model = new RequestCharges();
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    $model->created_by = Yii::$app->user->identity->id;
                    $model->updated_by = Yii::$app->user->identity->id;
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Request charge was successfully created.');
                    } else {
                        $message = '';
                        foreach ($model->getErrors() as $error) {
                            $message .= $error[0];
                        }
                        Yii::$app->session->setFlash('warning', "Request charge was not created. Error occured. Error::" . $message);
                    }
                }
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Deletes an existing RequestCharges model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (User::isUserAllowedTo("Manage request charges")) {
            if ($this->findModel($id)->delete()) {
                Yii::$app->session->setFlash('success', 'Request charge was removed successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Request charge was not removed.');
            }

            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Finds the RequestCharges model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return RequestCharges the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (User::isUserAllowedTo("Manage request charges")) {
            if (($model = RequestCharges::findOne(['id' => $id])) !== null) {
                return $model;
            }

            throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

}
