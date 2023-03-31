<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use \frontend\models\ClientUsers;
use yii\helpers\Json;
use yii\web\UploadedFile;
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
                'class' => AccessControl::class,
                'only' => ['logout', 'register'],
                'rules' => [
                    [
                        'actions' => ['register'],
                        'allow' => true,
                        'roles' => ['?'],
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
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        return $this->redirect(['login']);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {

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
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionRegister() {
        $this->layout = 'register';
        $model = new Organisations();

        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->active = Organisations::STATUS_INACTIVE;
            $model->username = $model->email;
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->password = Yii::$app->getSecurity()->generatePasswordHash(Yii::$app->security->generateRandomString() . $model->auth_key);
            $logo = UploadedFile::getInstance($model, 'logo');
            $filename = "";
            if ($model->save()) {
                //Lets save the logo
                if (!empty($logo)) {
                    $model->logo = Yii::$app->security->generateRandomString() . "." . $logo->extension;
                    $logo->saveAs(Yii::getAlias('@frontend') . '/web/uploads/' . $model->logo);
                    $model->save(false);
                }
                $resetPasswordModel = new PasswordResetRequestForm();
                if ($resetPasswordModel->sendEmailAccountCreation($model->email)) {
                    Yii::$app->session->setFlash('success', 'Your organisation registration was successful. Check the provided email inbox to complete the registeration.');
                } else {
                    Yii::$app->session->setFlash('error', "Your organisation registration was successful but email to complete registration was not sent!");
                }
                return $this->redirect(['register']);
            } else {
                $message = '';
                foreach ($model->getErrors() as $error) {
                    $message .= $error[0];
                }
                Yii::$app->session->setFlash('error', "Error occured while registering organisation.Please try again.Error::" . $message);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
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
                Yii::$app->session->setFlash('success', 'A reset link has been sent to the registered email!');
                return $this->redirect(['login']);
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
            return $this->redirect(['login']);
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
        $user = ClientUsers::findByPasswordResetTokenInactiveAccount($token);
        if (!$user) {
            Yii::$app->session->setFlash('error', 'Account activation token expired. Contact  support!');
            return $this->redirect(['login']);
        }

        try {
            $this->layout = 'setpassword';
            $model = new \frontend\models\SetPasswordForm($token);
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', 'Account activation token expired. Contact support!.');
            return $this->redirect(['login']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Account activation was successfully completed. Login into your account!');
            return $this->redirect(['login']);
        }

        return $this->render('setPassword', [
                    'model' => $model,
                    'client' => \backend\models\Clients::findOne($user->client)
        ]);
    }

    /**
     * @param $token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function actionResetPassword($token) {
        $user = ClientUsers::findByPasswordResetToken($token);
        if (!$user) {
            Yii::$app->session->setFlash('error', 'Password reset token expired. Contact  support!');
            return $this->redirect(['login']);
        }
        
        try {
            $this->layout = 'resetpassword';
            $model = new ResetPasswordForm($token);
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', 'Password reset token has expired. Please request another one!.');
            return $this->redirect(['login']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Password was successfully reset. Sign in with your new password');
            return $this->redirect(['login']);
        }

        $this->layout = 'resetpassword';
        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token) {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail() {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
                    'model' => $model
        ]);
    }

    public function actionCountries() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $region = $parents[0];
                $out = \backend\models\Countries::find()
                        ->select(['id', 'name'])
                        ->where(['region' => $region])
                        ->asArray()
                        ->all();

                return ['output' => $out, 'selected' => ""];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

}
