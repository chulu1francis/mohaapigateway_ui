<?php

namespace backend\controllers;

use yii\filters\AccessControl;
use backend\models\User;
use backend\models\AuditTrail;
use yii\helpers\Json;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use backend\models\Utils;
use backend\models\PasswordResetRequestForm;
use yii\web\UploadedFile;
use backend\models\AauthUserFiles;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'update-image'
                        ],
                        'rules' => [
                            [
                                'actions' => [
                                    'index', 'create', 'update', 'delete', 'view', 'update-image'
                                ],
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

    public function actionUpdateImage($id) {
        $model = $this->findModel($id);
        $oldFile = $model->image;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $profile = UploadedFile::getInstance($model, 'image');

            //Lets save the logo
            if (!empty($profile)) {
                $model->image = Yii::$app->security->generateRandomString() . "." . $profile->extension;
                $profile->saveAs(Yii::getAlias('@backend') . '/web/uploads/' . $model->image);

                if ($model->save(false)) {
                    if (!empty($oldFile)) {
                        if (file_exists(Yii::getAlias('@backend') . '/web/uploads/' . $oldFile)) {
                            unlink(Yii::getAlias('@backend') . '/web/uploads/' . $oldFile);
                        }
                    }

                    Yii::$app->session->setFlash('success', "User profile successfull updated");
                } else {
                    $message = '';
                    foreach ($model->getErrors() as $error) {
                        $message .= $error[0];
                    }
                    Yii::$app->session->setFlash('error', "Error occured while updating user profile.Please try again.Error::" . $message);
                }
            }
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex() {
        if (User::isUserAllowedTo("Manage users") || User::isUserAllowedTo("View Users")) {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            $dataProvider->pagination->pageSize = 10;
            //User should not see their own user row. Use my profile to edit their user details
            $dataProvider->query->andFilterWhere(['NOT IN', 'id', [Yii::$app->getUser()->identity->id]]);

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
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        if (User::isUserAllowedTo("Manage users") || User::isUserAllowedTo("View Users")) {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        if (User::isUserAllowedTo("Manage users")) {
            $model = new User();
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    $model->created_by = Yii::$app->user->id;
                    $model->updated_by = Yii::$app->user->id;
                    $model->active = User::STATUS_INACTIVE;
                    $model->username = $model->email;
                    $model->auth_key = Yii::$app->security->generateRandomString();
                    $model->password = Yii::$app->getSecurity()->generatePasswordHash(Yii::$app->security->generateRandomString() . $model->auth_key);
                    $days = \Yii::$app->params['passwordValidity'] * 30;
                    $model->expiry_date = date('Y-m-d', (strtotime('+' . $days . 'days', strtotime(date("Y-m-d")))));
                    $profile = UploadedFile::getInstance($model, 'image');
                    $model->image = Yii::$app->security->generateRandomString() . "." . $profile->extension;
                    $profile->saveAs(Yii::getAlias('@backend') . '/web/uploads/' . $model->image);

                    if ($model->save()) {
                        $resetPasswordModel = new PasswordResetRequestForm();
                        if ($resetPasswordModel->sendEmailAccountCreation($model->email)) {
                            Yii::$app->session->setFlash('success', 'User account with email:' . $model->email . ' was successfully created.');
                            return $this->redirect(['view', 'id' => $model->id]);
                        } else {
                            Yii::$app->session->setFlash('error', "User account created but activation email was not sent!");
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    } else {
                        $message = '';
                        foreach ($model->getErrors() as $error) {
                            $message .= $error[0];
                        }
                        Yii::$app->session->setFlash('error', "Error occured while creating user.Please try again.Error::" . $message);
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        if (User::isUserAllowedTo("Manage users")) {
            $model = $this->findModel($id);
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            $oldProfile = $model->image;

            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->updated_by = Yii::$app->user->id;
                $model->username = $model->email;
                $profile = UploadedFile::getInstance($model, 'image');
                $model->image = Yii::$app->security->generateRandomString() . "." . $profile->extension;
                $profile->saveAs(Yii::getAlias('@backend') . '/web/uploads/' . $model->image);

                if ($model->save()) {
                    if (!empty($oldProfile)) {
                        if (file_exists(Yii::getAlias('@backend') . '/web/uploads/' . $oldProfile)) {
                            unlink(Yii::getAlias('@backend') . '/web/uploads/' . $oldProfile);
                        }
                    }

                    Yii::$app->session->setFlash('success', 'User account was successfully updated.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $message = '';
                    foreach ($model->getErrors() as $error) {
                        $message .= $error[0];
                    }
                    Yii::$app->session->setFlash('error', "Error occured while updating user.Please try again.Error::" . $message);
                }
                return $this->redirect(['view', 'id' => $model->id]);
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (User::isUserAllowedTo("Manage users")) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSchools() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $campus = $parents[0];
                $out = \backend\models\Schools::find()
                        ->select(['id', 'name'])
                        ->where(['campus' => $campus])
                        ->asArray()
                        ->all();

                return ['output' => $out, 'selected' => ""];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionDepartments() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $campus = $parents[0];
                $out = \backend\models\Departments::find()
                        ->select(['id', 'name'])
                        ->where(['school' => $campus])
                        ->asArray()
                        ->all();

                return ['output' => $out, 'selected' => ""];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

}
