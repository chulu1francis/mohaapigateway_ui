<?php

namespace backend\controllers;

use Yii;
use backend\models\AauthUserToGroup;
use backend\models\AauthUserToGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\User;
use backend\models\AuditTrail;
use yii\helpers\Json;
use backend\models\AauthGroups;

/**
 * UserToGroupController implements the CRUD actions for AauthUserToGroup model.
 */
class UserToGroupController extends Controller {

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
     * Lists all AauthUserToGroup models.
     *
     * @return string
     */
    public function actionIndex() {
        if (User::isUserAllowedTo("Manage user to group")) {
            $searchModel = new AauthUserToGroupSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            $dataProvider->pagination->pageSize = 10;

            if (Yii::$app->request->post('hasEditable')) {
                $userId = Yii::$app->request->post('editableKey');
                $model = AauthUserToGroup::findOne($userId);
                $out = Json::encode(['output' => '', 'message' => '']);
                $posted = current($_POST['AauthUserToGroup']);
                $post = ['AauthUserToGroup' => $posted];

                if ($model->load($post)) {
                    $model->updated_by = Yii::$app->user->id;
                    $model->save(false);

                    //lets do some logging
                    if ($model->active == 1) {
                        $action = "Activated user to group assignment. User(" . $model->user0->id . ") man number:" . $model->user0->man_number . ", group:" . $model->group0->name;
                    } else {
                        $action = "Deactivated user to group assignment. User(" . $model->user0->id . ") man number:" . $model->user0->man_number . ", group:" . $model->group0->name;
                    }

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
     * Creates a new AauthUserToGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        if (User::isUserAllowedTo("Manage user to group")) {
            $model = new AauthUserToGroup();
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\kartik\widgets\ActiveForm::validate($model));
            }

            if ($this->request->isPost) {
                $model->created_by = Yii::$app->user->id;
                $model->updated_by = Yii::$app->user->id;
                $model->active = 1;
                if ($model->load($this->request->post()) && $model->save()) {

                    Yii::$app->session->setFlash('success', 'User successfully assigned user group.');
                    //lets do some logging
                    $action = "Assigned user(id:" . $model->user . ") with man number:" . $model->user0->man_number . " user group:" . $model->group0->name;
                    $extraData = "";
                    AuditTrail::logTrail($action, $extraData);
                } else {
                    Yii::$app->session->setFlash('error', 'Error occured while assigning user to group. Please try again later!');
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
     * Deletes an existing AauthUserToGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (User::isUserAllowedTo("Manage user to group")) {
            try {

                $model = $this->findModel($id);
                $user = $model->user0;
                $group = $model->group0->name;

                if ($model->delete()) {
                    //lets do some logging
                    $action = "Deleted user to group assignment. User(" . $user->id . ") man no:" . $user->man_number . ", group:" . $group;
                    $extraData = "";
                    AuditTrail::logTrail($action, $extraData);
                    Yii::$app->session->setFlash('success', 'User to group assignment was successfully deleted.');
                } else {
                    Yii::$app->session->setFlash('error', 'Error occured while deleting user to group assignment. Please try again!');
                }

                return $this->redirect(['index']);
            } catch (yii\db\IntegrityException | Exception $ex) {
                Yii::$app->session->setFlash('error', 'Error occured while removing user to group assignment. Please try again!');
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Finds the AauthUserToGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AauthUserToGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AauthUserToGroup::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
