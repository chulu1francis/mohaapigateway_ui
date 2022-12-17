<?php

namespace backend\controllers;

use Yii;
use backend\models\AauthGroups;
use backend\models\AauthGroupsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\User;
use backend\models\AuditTrail;
use yii\helpers\Json;
use \backend\models\AauthPermToGroup;

/**
 * GroupsController implements the CRUD actions for AauthGroups model.
 */
class GroupsController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['index', 'create', 'update', 'delete', 'view'],
                        'rules' => [
                            [
                                'actions' => ['index', 'create', 'update', 'delete', 'view'],
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
     * Lists all AauthGroups models.
     *
     * @return string
     */
    public function actionIndex() {
        if (User::isUserAllowedTo("Manage groups") || User::isUserAllowedTo("View groups")) {
            $searchModel = new AauthGroupsSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            $dataProvider->pagination->pageSize = 10;

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
     * Displays a single AauthGroups model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        if (User::isUserAllowedTo("Manage groups") || User::isUserAllowedTo("View groups")) {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Creates a new AauthGroups model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        if (User::isUserAllowedTo("Manage groups")) {
            $model = new AauthGroups();
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            if ($this->request->isPost) {
                $model->created_by = Yii::$app->user->id;
                $model->updated_by = Yii::$app->user->id;
                if ($model->load($this->request->post()) && $model->save()) {
                    foreach ($model->permissions as $right) {
                        $permissionAllocation = new AauthPermToGroup();
                        $permissionAllocation->group = $model->id;
                        $permissionAllocation->permission = $right;
                        $permissionAllocation->created_by = Yii::$app->user->id;
                        $permissionAllocation->updated_by = Yii::$app->user->id;
                        $permissionAllocation->save(false);
                    }

                    //lets do some logging
                    $action = "Created user group:" . $model->name;
                    $extraData = "";
                    AuditTrail::logTrail($action, $extraData);
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Error occured while creating user group. Please try again later!');
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
     * Updates an existing AauthGroups model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        if (User::isUserAllowedTo("Manage groups")) {
            $model = $this->findModel($id);
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }
            $model->permissions = AauthPermToGroup::getGroupPermissions($model->id);

            $array = [];
            foreach ($model->permissions as $perm => $v) {
                array_push($array, $perm);
            }
            $model->permissions = $array;

            if ($this->request->isPost) {
                $model->updated_by = Yii::$app->user->id;
                if ($model->load($this->request->post()) && $model->save()) {
                    $permToGroupModel = new AauthPermToGroup();
                    $permToGroupModel::deleteAll(['group' => $model->id]);
                    foreach ($model->permissions as $right) {
                        $permissionAllocation = new AauthPermToGroup();
                        $permissionAllocation->group = $model->id;
                        $permissionAllocation->permission = $right;
                        $permissionAllocation->created_by = Yii::$app->user->id;
                        $permissionAllocation->updated_by = Yii::$app->user->id;
                        $permissionAllocation->save(false);
                    }

                    //lets do some logging
                    $action = "Updated user group:" . $model->name;
                    $extraData = "";
                    AuditTrail::logTrail($action, $extraData);

                    //check if current user has the group that has just been edited so that 
                    //we update the permissions instead of user logging out
                    $groupModel = Yii::$app->getUser()->identity->group0;
                    if (Yii::$app->getUser()->identity->group0->id == $model->id) {
                        $rightsArray = \backend\models\AauthPermToGroup::getGroupPermissions($groupModel->id);
                        $rights = implode(",", $rightsArray);
                        $session = Yii::$app->session;
                        $session->set('rights', $rights);
                    }
                    Yii::$app->session->setFlash('success', 'User group ' . $model->name . ' was successfully updated.');
                    return $this->redirect(['view', 'id' => $model->id]);
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
     * Deletes an existing AauthGroups model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (User::isUserAllowedTo("Manage groups")) {
            try {
                //We first check if there are users attached to the group
                $userCount = User::find()->where(['group' => $id])->count();
                if ($userCount > 0) {
                    Yii::$app->session->setFlash('error', 'User group has ' . $userCount . " users attached to it. Kindly unattached all users before deleting it!");
                    return $this->redirect(['index']);
                }

                //Lets delete the permissions assigned to the group
                AauthPermToGroup::deleteAll(['group' => $id]);

                //Lets delete the group now
                $model = $this->findModel($id);
                $name = $model->name;
                if ($model->delete()) {
                    //lets do some logging
                    $action = "Deleted user group:" . $name . " with its associated permissions";
                    $extraData = "";
                    AuditTrail::logTrail($action, $extraData);
                    Yii::$app->session->setFlash('success', 'User group ' . $name . ' was successfully deleted.');
                } else {
                    Yii::$app->session->setFlash('error', 'User group ' . $name . ' could not be deleted. Please try again!');
                }

                return $this->redirect(['index']);
            } catch (yii\db\IntegrityException | Exception $ex) {
                Yii::$app->session->setFlash('error', 'Error occured while removing user group. Looks like group has users attached to it!');
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Finds the AauthGroups model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AauthGroups the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AauthGroups::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
