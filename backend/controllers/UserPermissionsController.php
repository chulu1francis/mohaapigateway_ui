<?php

namespace backend\controllers;

use backend\models\AauthPermToUser;
use backend\models\AauthPermToUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\User;
use backend\models\AuditTrail;
use yii\helpers\Json;
use Yii;

/**
 * UserPermissionsController implements the CRUD actions for AauthPermToUser model.
 */
class UserPermissionsController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['index', 'create', 'delete'],
                        'rules' => [
                            [
                                'actions' => ['index', 'create', 'delete'],
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
     * Lists all AauthPermToUser models.
     *
     * @return string
     */
    public function actionIndex() {
        if (User::isUserAllowedTo("Assign permission to user")) {
            $searchModel = new AauthPermToUserSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            $dataProvider->pagination->pageSize = 10;

            if (Yii::$app->request->post('hasEditable')) {
                $userId = Yii::$app->request->post('editableKey');
                $model = AauthPermToUser::findOne($userId);
                $out = Json::encode(['output' => '', 'message' => '']);
                $posted = current($_POST['AauthPermToUser']);
                $post = ['AauthPermToUser' => $posted];

                if ($model->load($post)) {

                    if ($model->active == 1) {
                        if ($model->expiry_date < date("Y-m-d H:i:s")) {
                            $expiryDate = AauthPermToUser::getPermissionExpiry();
                            $model->expiry_date = $expiryDate;
                        }
                        $action = "Extended permission assignment for User(" . $model->user0->id . ") man number:" . $model->user0->man_number . ", permission:" . $model->permission0->name . " to date:" . $expiryDate;
                    } else {
                        $model->expiry_date = date("Y-m-d H:i:s");
                        $action = "Revoked user permission. User(" . $model->user0->id . ") man number:" . $model->user0->man_number . ", permission:" . $model->permission0->name;
                    }
                    $model->updated_by = Yii::$app->user->id;
                    $model->save(false);

                    //lets do some logging
                    $extraData = "";
                    AuditTrail::logTrail($action, $extraData);
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
     * Creates a new AauthPermToUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        if (User::isUserAllowedTo("Assign permission to user")) {
            $model = new AauthPermToUser();
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\kartik\widgets\ActiveForm::validate($model));
            }

            if ($this->request->isPost) {
                $model->created_by = Yii::$app->user->id;
                $model->updated_by = Yii::$app->user->id;
                $model->active = 1;
                $model->expiry_date = AauthPermToUser::getPermissionExpiry();

                if ($model->load($this->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'User successfully assigned permission.');
                    //lets do some logging
                    $action = "Assigned user(id:" . $model->user . ") with man number:" . $model->user0->man_number . " permission:" . $model->permission0->name;
                    $extraData = "";
                    AuditTrail::logTrail($action, $extraData);
                } else {
                    var_dump($model->getErrors());
                    exit();
                    Yii::$app->session->setFlash('error', 'Error occured while assigning permission to user. Please try again later!');
                }
                return $this->redirect(['index']);
            } else {
                $model->loadDefaultValues();
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Deletes an existing AauthPermToUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (User::isUserAllowedTo("Assign permission to user")) {
            try {

                $model = $this->findModel($id);
                $user = $model->user0;
                $permission = $model->permission0->name;

                if ($model->delete()) {
                    //lets do some logging
                    $action = "Deleted user permission assignment. User(" . $user->id . ") man no:" . $user->man_number . ", permission:" . $permission;
                    $extraData = "";
                    AuditTrail::logTrail($action, $extraData);
                    Yii::$app->session->setFlash('success', 'User permission assignment was successfully deleted.');
                } else {
                    Yii::$app->session->setFlash('error', 'Error occured while deleting user permission assignment. Please try again!');
                }

                return $this->redirect(['index']);
            } catch (yii\db\IntegrityException | Exception $ex) {
                Yii::$app->session->setFlash('error', 'Error occured while removing user permission assignment. Please try again!');
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Finds the AauthPermToUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AauthPermToUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AauthPermToUser::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
