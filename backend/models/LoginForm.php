<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model {

    public $username;
    public $password;
    public static $rememberMe2 = true;
    public $rememberMe = true;
    public $verifyCode;
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            ['username', 'number', 'message' => "Man no must be a number!"],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            [['username', 'password', 'verifyCode'], 'required', 'on' => 'captchaRequired'],
            ['verifyCode', 'captcha', 'captchaAction' => '/site/captcha', 'on' => 'captchaRequired','message' => "Captcha code is incorrect!"], // add this code to your rules.
        ];
    }

    public function attributeLabels() {
        return [
            'username' => 'Man no',
            'verifyCode' => 'Captcha code',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect man no or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return HeaUser|null
     */
    protected function getUser() {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

}
