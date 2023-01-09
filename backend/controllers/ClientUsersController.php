<?php

namespace backend\controllers;

use frontend\models\ClientUsers;
use frontend\models\ClientUsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use Yii;
use yii\filters\AccessControl;
use backend\models\User;
use frontend\models\PasswordResetRequestForm;

/**
 * ClientUsersController implements the CRUD actions for ClientUsers model.
 */
class ClientUsersController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['index', 'create', 'update', 'delete',],
                        'rules' => [
                            [
                                'actions' => ['index', 'create', 'update', 'delete'],
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
     * Lists all ClientUsers models.
     *
     * @return string
     */
    public function actionIndex() {
        if (User::isUserAllowedTo("View client users") || User::isUserAllowedTo("Manage client users")) {
            $searchModel = new ClientUsersSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            if (Yii::$app->request->post('hasEditable')) {
                $userId = Yii::$app->request->post('editableKey');
                $model = ClientUsers::findOne($userId);
                $out = Json::encode(['output' => '', 'message' => '']);
                $posted = current($_POST['ClientUsers']);
                $post = ['ClientUsers' => $posted];

                if ($model->load($post)) {
                    $model->updated_by = Yii::$app->user->id;
                    $model->save(false);
                    $output = '';
                    $out = Json::encode(['output' => $output, 'message' => '']);
                }
                return $out;
            }

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
     * Creates a new ClientUsers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        if (User::isUserAllowedTo("Manage client users")) {
            $model = new ClientUsers();
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            $model->scenario = 'onSubmit';
            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {

                    $model->username = $model->email;
                    $model->auth_key = Yii::$app->security->generateRandomString(15);
                    $model->active = 0;
                    $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash(Yii::$app->security->generateRandomString() . $model->auth_key);
                    $model->created_by = Yii::$app->user->identity->id;
                    $model->updated_by = Yii::$app->user->identity->id;
                    if ($model->save()) {
                        $resetPasswordModel = new PasswordResetRequestForm();
                        if ($resetPasswordModel->sendEmailAccountCreation($model->email)) {
                            Yii::$app->session->setFlash('success', 'Client user was successfully created.');
                        } else {
                            Yii::$app->session->setFlash('error', "Client user was created successfully but email to activate account was not sent!");
                        }
                        return $this->redirect(['index']);
                    } else {
                        $message = '';
                        foreach ($model->getErrors() as $error) {
                            $message .= $error[0];
                        }
                        Yii::$app->session->setFlash('warning', "Client user was not created. Error occured. Error::" . $message);
                    }
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                        'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Updates an existing ClientUsers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        if (User::isUserAllowedTo("Manage client users")) {
            $model = $this->findModel($id);
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->updated_by = Yii::$app->user->identity->id;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Client user was successfully updated.');
                    return $this->redirect(['index']);
                } else {
                    $message = '';
                    foreach ($model->getErrors() as $error) {
                        $message .= $error[0];
                    }
                    Yii::$app->session->setFlash('warning', "Client user was not updated. Error occured. Error::" . $message);
                }
            }

            return $this->render('update', [
                        'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Deletes an existing ClientUsers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (User::isUserAllowedTo("Manage client users")) {
            if($this->findModel($id)->delete()){
             Yii::$app->session->setFlash('success', 'Client user was successfully removed.');   
            }else{
               Yii::$app->session->setFlash('error', 'Client user could not be removed.'); 
            }

            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Finds the ClientUsers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ClientUsers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ClientUsers::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
