<?php

namespace backend\controllers;

use backend\models\Clients;
use backend\models\ClientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\User;
use yii\helpers\Json;
use Yii;
use \backend\models\ClientAttributes;
use backend\models\ClientIpWhitelist;
use frontend\models\PasswordResetRequestForm;
use \frontend\models\ClientUsers;

/**
 * ClientsController implements the CRUD actions for Clients model.
 */
class ClientsController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['index', 'create', 'update', 'delete', 'view', 'update-attributes', 'whitelist-ip'],
                        'rules' => [
                            [
                                'actions' => ['index', 'create', 'update', 'delete', 'view', 'update-attributes', 'whitelist-ip'],
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
     * Lists all Clients models.
     *
     * @return string
     */
    public function actionIndex() {
        if (User::isUserAllowedTo("View clients") || User::isUserAllowedTo("Manage clients")) {
            $searchModel = new ClientsSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            if (Yii::$app->request->post('hasEditable')) {
                $userId = Yii::$app->request->post('editableKey');
                $model = Clients::findOne($userId);
                $out = Json::encode(['output' => '', 'message' => '']);
                $posted = current($_POST['Clients']);
                $post = ['Clients' => $posted];

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
     * Whitelist client IP address
     * @param type $id
     * @return type
     */
    public function actionWhitelistIp($id) {
        if (User::isUserAllowedTo('Manage clients')) {
            $model = new ClientIpWhitelist();
            $msg = "Client IP address was successfully whitelisted";
            $oldIP = "";
            if (!empty($id)) {
                $ipModel = ClientIpWhitelist::findOne(['client' => $id]);
                if (!empty($ipModel)) {
                    $msg = "Client IP address was successfully updated";
                    $model = $ipModel;
                    $oldIP = $ipModel->ip;
                }
            }



            if ($this->request->isPost && $model->load($this->request->post())) {

                $model->created_by = Yii::$app->user->identity->id;
                $model->updated_by = Yii::$app->user->identity->id;
                $model->client = $id;

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', $msg);
                    $cache = Yii::$app->redis;

                    //We push the client ip to redis server
                    $ipWhitelist = $cache->get("ipWhitelist");
                    if (!empty($ipWhitelist)) {
                        if(!empty($oldIP)){
                           $ipWhitelist= str_replace($oldIP.',', "", $ipWhitelist);
                        }
                        
                        if (!str_contains($ipWhitelist, $model->ip)) {
                            $ipWhitelist .= $model->ip.",";
                            $cache->set("ipWhitelist", "$ipWhitelist");
                        }
                    } else {
                        $ip=$model->ip.",";
                        $cache->set("ipWhitelist", "$ip");
                    }
                } else {
                    $message = '';
                    foreach ($model->getErrors() as $error) {
                        $message .= $error[0];
                    }
                    Yii::$app->session->setFlash('error', "Client IP address could not be whitelisted. Please try again.Error::" . $message);
                }
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    public function actionUpdateAttributes($id) {
        if (User::isUserAllowedTo("Manage clients")) {
            $model = new ClientAttributes();
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    $model::deleteAll(['client' => $id]);

                    foreach ($model->attributes as $attribute) {
                        $clientAttributesModel = new ClientAttributes();
                        $clientAttributesModel->client = $id;
                        $clientAttributesModel->attribute = $attribute;
                        $clientAttributesModel->created_by = Yii::$app->user->id;
                        $clientAttributesModel->updated_by = Yii::$app->user->id;
                        $clientAttributesModel->save(false);
                    }
                    Yii::$app->session->setFlash('success', 'Client attributes have been updated successfully');
                }
            }
            return $this->redirect(['view', 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Displays a single Clients model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        if (User::isUserAllowedTo("View clients") || User::isUserAllowedTo("Manage clients")) {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Creates a new Clients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        if (User::isUserAllowedTo("Manage clients")) {
            $model = new Clients();
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    $model->active = 1;
                    $model->created_by = Yii::$app->user->identity->id;
                    $model->updated_by = Yii::$app->user->identity->id;
                    $model->username = $model->email;
                    $model->auth_key = Yii::$app->security->generateRandomString(15);
                    $model->secret_key = "__" . Yii::$app->security->generateRandomString(50);
                    // $newSecretkey = $secretKey . $model->auth_key;
                    $model->username = self::generateCode();

//                    //We encode the secret key using the authentication api
//                    $url = Yii::$app->params['baseAPIUrl'] . Yii::$app->params['encodeEndpoint'] . $newSecretkey;
//                    $result = SharedUtils::getJson($url);
//                    if ($result["status"] == 1 && !empty($result["content"])) {
//                        //Get the encoded key
//                        $model->secret_key = json_decode($result["content"], true);
                    //Save the model
                    if ($model->save()) {
                        //We create a client user
                        $clientUserModel = new ClientUsers();
                        $clientUserModel->client = $model->id;
                        $clientUserModel->first_name = $model->contact_person_first_name;
                        $clientUserModel->last_name = $model->contact_person_last_name;
                        $clientUserModel->email = $model->email;
                        $clientUserModel->username = $clientUserModel->email;
                        $clientUserModel->auth_key = Yii::$app->security->generateRandomString(15);
                        $clientUserModel->active = 0;
                        $clientUserModel->password_hash = Yii::$app->getSecurity()->generatePasswordHash(Yii::$app->security->generateRandomString() . $model->auth_key);
                        $clientUserModel->created_by = Yii::$app->user->identity->id;
                        $clientUserModel->updated_by = Yii::$app->user->identity->id;
                        if ($clientUserModel->save()) {
                            $resetPasswordModel = new PasswordResetRequestForm();
                            if ($resetPasswordModel->sendEmailAccountCreation($clientUserModel->email)) {
                                Yii::$app->session->setFlash('success', 'Client was successfully created.');
                            } else {
                                Yii::$app->session->setFlash('warning', "Client was created successfully but default user email to activate account was not sent!");
                            }
                        } else {
                            $message = '';
                            foreach ($clientUserModel->getErrors() as $error) {
                                $message .= $error[0];
                            }
                            Yii::$app->session->setFlash('warning', "Client was created but default user was not created. Error::" . $message);
                        }

                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        $message = '';
                        foreach ($model->getErrors() as $error) {
                            $message .= $error[0];
                        }
                        Yii::$app->session->setFlash('error', 'Error occured while saving client details.Error:' . $message);
                    }
//                    } else {
//                        Yii::$app->session->setFlash('error', 'Error occured while creating client. Please ensure the authentication service is running and try again!');
//                    }
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
     * Updates an existing Clients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        if (User::isUserAllowedTo("Manage clients")) {
            $model = $this->findModel($id);

            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->updated_by = Yii::$app->user->identity->id;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Client:' . $model->name . ' was successfully updated ');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $message = '';
                    foreach ($model->getErrors() as $error) {
                        $message .= $error[0];
                    }
                    Yii::$app->session->setFlash('error', "Error occured while updating client: $model->name. Please try again.Error::" . $message);
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
     * Deletes an existing Clients model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (User::isUserAllowedTo("Manage clients")) {
            try {
                $model = $this->findModel($id);
                $name = $model->name;
                if ($model->delete()) {
                    Yii::$app->session->setFlash('success', 'Client:' . $name . ' was successfully removed ');
                } else {
                    Yii::$app->session->setFlash('error', 'Client:' . $name . ' could not be removed ');
                }
                return $this->redirect(['index']);
            } catch (\yii\db\IntegrityException $ex) {
                Yii::$app->session->setFlash('error', 'Client could not be removed. Possibly client is attached to a record in the system.'
                        . 'if you are authorized,please remove the record and try again!');
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Generate client code
     * @return type
     */
    private static function generateCode() {
        $code = date('ymds');
        ;
        if (!empty(Clients::findOne(['username' => $code]))) {
            $code = $code + 1;
        }
        return $code;
    }

    /**
     * Finds the Clients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Clients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Clients::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
