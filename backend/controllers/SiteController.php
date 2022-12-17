<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use backend\models\User;
use backend\models\LoginForm;
use backend\models\AauthUserToGroup;
use backend\models\AauthPermToGroup;
use backend\models\AauthPermToUser;

/**
 * Site controller
 */
class SiteController extends Controller {

    public $counter;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'login'],
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'captcha'],
                        'allow' => true,
                    // 'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        if (Yii::$app->user->isGuest) {
            $layout = $this->layout = 'error';
        } else {
            $layout = $this->layout = 'main';
        }

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => $layout,
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->redirect(['login']);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
//        if (!empty(Yii::$app->session->get('__authKey')) && !empty(Yii::$app->session->get('__expire'))) {
//            return $this->redirect(['home/index']);
//        }

        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->goHome();
        }

        $this->layout = 'login';
        $model = new LoginForm();
        if ($this->captchaRequired()) {
            $model->scenario = "captchaRequired";
        }
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                $this->counter = 0;
                Yii::$app->session['captchaRequired'] = 0;
                $groupModel = Yii::$app->getUser()->identity->group0;
                $rightsArray = AauthPermToGroup::getGroupPermissions($groupModel->id);
                $rights = implode(",", $rightsArray);

                //Now lets check group permissions
                $userToGroupPermissions = AauthUserToGroup::getActiveUserToGroupPermissions(Yii::$app->user->identity->id);
                if (!empty($userToGroupPermissions)) {
                    $rights .= "," . $userToGroupPermissions;
                }

                //Now lets check special permissions
                $specialPerms = AauthPermToUser::getSpecialPermissions(Yii::$app->user->identity->id);
                if (!empty($specialPerms)) {
                    foreach ($specialPerms as $value) {
                        $rights .= "," . $value;
                    }
                }
                
                $session = Yii::$app->session;
                $session->set('rights', $rights);

                return $this->redirect(['home/index']);
            } else {
                $model->password = '';
                $this->counter = Yii::$app->session['captchaRequired'] + 1;
                Yii::$app->session->set('captchaRequired', $this->counter);
            }
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     *  Check captcha count
     * @return type
     */
    private function captchaRequired() {
        return Yii::$app->session['captchaRequired'] >= Yii::$app->params['wrongPasswordCounter'];
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
