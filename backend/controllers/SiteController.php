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
use backend\models\AuditTrail;
use backend\models\PasswordResetRequestForm;
use yii\helpers\Json;
use backend\models\ResetPasswordForm;
use backend\models\ResetPasswordForm_1;

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
                'only' => ['logout', 'login', 'set-password',
                    'request-password-reset', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'captcha', 'set-password',
                            'request-password-reset', 'reset-password'],
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

    /**
     * Requests password reset.
     *
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                $user = User::findOne(['email' => $model->email]);
                if ($user) {
                    $action = "Requested password reset";
                    $extraData = "";
                    AuditTrail::logTrailUser($action, $extraData, $user->id);
                }
                Yii::$app->session->setFlash('success', 'A reset link has been sent to your email!');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address!');
            }
        }
        $this->layout = 'requestPasswordReset';
        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function actionResetPassword1($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');
            $ath = new AuditTrail();
            $ath->user = $user->id;
            $ath->action = "New password saved.";
            $ath->ip_address = Yii::$app->request->getUserIP();
            $ath->user_agent = Yii::$app->request->getUserAgent();
            $ath->save();
            return $this->goHome();
        }
        $this->layout = 'login';
        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionSetPassword($token) {
        $user = User::findByPasswordResetTokenInactiveAccount($token);
        if (!$user) {
            Yii::$app->session->setFlash('error', 'Account activation token expired. Contact  support!');
            return $this->goHome();
        }

        try {
            $this->layout = 'setpassword';
            $model = new \backend\models\SetPasswordForm($token);
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', 'Account activation token expired. Contact support!.');
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            $action = "Activated account by setting the password.";
            $extraData = "";
            AuditTrail::logTrailUser($action, $extraData, $user->id);
            Yii::$app->session->setFlash('success', 'Account was successfully activated. Login into your account!');
            return $this->goHome();
        }

        return $this->render('setPassword', [
                    'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function actionResetPassword($token) {
        try {
            $this->layout = 'resetpassword';
            $model = new ResetPasswordForm($token);
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', 'Password reset token has expired. Please request another one!.');
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Password was successfully reset. Sign in with your new password');
            return $this->goHome();
        }
        
        $this->layout = 'resetpassword';
        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

}
