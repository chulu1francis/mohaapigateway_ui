<?php

namespace frontend\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\Json;
use \backend\models\Clients;
use common\models\SharedUtils;

class HomeController extends \yii\web\Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['index', 'generate-key', 'update-logo'],
                        'rules' => [
                            [
                                'actions' => ['index', 'generate-key', 'update-logo'],
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
     * Creates a new OrganisationRegistrationDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionGenerateKey() {
        $model = Clients::findOne(Yii::$app->getUser()->identity->client);
        $cache = Yii::$app->cache;

        if (!empty($model)) {
            $model->auth_key = Yii::$app->security->generateRandomString(10);
            $secretKey = Yii::$app->security->generateRandomString(10);
            $newSecretkey = $secretKey . $model->auth_key;

            //We encode the secret key using the authentication api
            $url = Yii::$app->params['baseAPIUrl'] . Yii::$app->params['encodeEndpoint'] . $newSecretkey;
            $result = SharedUtils::getJson($url);
           
            if ($result["status"] == 1 && !empty($result["content"])) {
                //Get the encoded key
                $model->secret_key = $result["content"];

                //Save the model
                if ($model->save(false)) {
                    //Lets encrypt the key
                    $url = Yii::$app->params['baseAPIUrl'] . Yii::$app->params['encryptEndpoint'] . $secretKey;
                    $result = SharedUtils::getJson($url);
                    
                    if ($result["status"] == 1 && !empty($result["content"])) {
                        $cache->set("C" . $model->id, $result["content"]);
                        Yii::$app->session->setFlash('success', 'API key was successfully generated');
                    } else {
                        Yii::$app->session->setFlash('error', 'Error occured while generating api key. Please again and if the problem persists contact system administrator!');
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'Error occured while generating api key. Please again and if the problem persists contact system administrator!');
            }
        }

        return $this->redirect(['index']);
    }

    public function actionIndex() {
        return $this->render('index', [
                    'model' => Yii::$app->getUser()->identity->client0,
        ]);
    }

}
