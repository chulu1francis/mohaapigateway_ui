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
                            'lms-account'
                        ],
                        'rules' => [
                            [
                                'actions' => ['index', 'create', 'update', 'delete', 'view', 'lms-account'],
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

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
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

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
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
     * Create users LMS account by making an http call
     * @param type $id
     * @return type
     */
    public function actionLmsAccount($id, $origin = "") {
        if (User::isUserAllowedTo("Manage users")) {
            $model = $this->findModel($id);
            $params = $this->lmsUserObject($model);
            if (!empty($params)) {
                $url = $this->buildUrl(Yii::$app->params['lms']['functions']['createUser']) . Utils::format_postdata_for_curlcall($params);
                $result = Utils::getJson($url);

                if (!empty($result) && $result['status'] === 1) {
                    if (isset($result['content'][0]['id']) && $result['content'][0]['id']) {
                        //We updated record
                        $model->lms_account_created = "Yes";
                        $model->save(false);
                        Yii::$app->session->setFlash('success', 'LMS account was created successfully');
                    } else {
                        $decodedContent = json_decode($result['content'], true);

                         //If user exists on the LMS, we update record
                        if (isset($decodedContent['debuginfo']) && str_starts_with($decodedContent['debuginfo'], "Username")) {
                            $model->lms_account_created = "Yes";
                            $model->save(false);
                        }
                        Yii::$app->session->setFlash('error', "LMS response is: " . $decodedContent['debuginfo']);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Error occured while creating LMS user account. Please try again!');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Error occured while creating LMS user account. Please try again!');
            }

            if ($origin == "index") {
                return $this->redirect(['index']);
            } else {
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Build LMS url
     * @param type $function
     * @return string
     */
    protected function buildUrl($function) {
        $url = Yii::$app->params['lms']['host']
                . Yii::$app->params['lms']['extension']
                . "?wstoken=" . Yii::$app->params['lms']['token']
                . "&wsfunction=" . $function
                . "&moodlewsrestformat=json&";
        return $url;
    }

    /**
     * Create the user object to be pushed to the LMS
     * @param type $model
     * @return array
     */
    protected function lmsUserObject($model) {
        $params = "";

        if (!empty($model)) {
            $user = new \stdClass();
            $user->username = $model->man_number;
            $user->password = $model->man_number;
            $user->firstname = $model->first_name;
            $user->lastname = $model->last_name;
            $user->email = trim($model->email);
            $user->auth = 'ws';
            $user->idnumber = $model->man_number;
            $user->lang = Yii::$app->params['lms']['lang'];
            $user->timezone = Yii::$app->params['lms']['timeZone'];
            $user->mailformat = 0;
            $user->description = Yii::$app->params['siteName'] . ' staff user creation';
            $user->city = "";
            $user->country = Yii::$app->params['lms']['countryCode'];
            $params = ['users' => [$user]];
        }
        return $params;
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

}
