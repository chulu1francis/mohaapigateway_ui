<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Organisations;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model {

    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => '\frontend\models\Organisations',
                'filter' => ['active' => Organisations::STATUS_ACTIVE], 'message' => 'There is no organisation registered with that email address!'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     * @throws \yii\base\Exception
     */
    public function sendEmail() {
        /* @var $user Organisations */
        $user = Organisations::findOne([
                    'active' => Organisations::STATUS_ACTIVE,
                    'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!Organisations::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save(false)) {
                return false;
            }
        }

        return Yii::$app
                        ->mailer
                        ->compose(
                                ['html' => 'passwordResetToken-html_1', 'text' => 'passwordResetToken-text'], ['user' => $user]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['supportEmail']])
                        ->setTo($this->email)
                        ->setSubject('Password reset for ' . Yii::$app->name)
                        ->send();
    }

    /**
     * Send user account creation email
     * @param type $email
     * @return boolean
     */
    public function sendEmailAccountCreation($email) {
        /* @var $user Organisations */
        $user = Organisations::findOne([
                    'active' => Organisations::STATUS_INACTIVE,
                    'email' => $email,
        ]);

        if (!$user) {
            return false;
        }



        if (!Organisations::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save(false)) {
                return false;
            }
        }


        return Yii::$app
                        ->mailer
                        ->compose(
                                [
                                    'html' => 'emailVerify-html_1',
                                    'text' => 'emailVerify-text'
                                ], ['user' => $user]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['supportEmail']])
                        ->setTo($email)
                        ->setSubject(Yii::$app->params['siteName'] . ' account')
                        ->send();
    }

}
