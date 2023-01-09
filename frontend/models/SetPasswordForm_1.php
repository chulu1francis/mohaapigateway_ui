<?php

namespace frontend\models;

use yii\base\Model;
use yii\base\Exception;
use backend\models\ClientUsers;
use kartik\password\StrengthValidator;

/**
 * Password reset form
 */
class SetPasswordForm extends Model {

    public $password;
    public $confirm_password;
    public $username;

    /**
     * @var \backend\models\ClientUsers
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new Exception('Token expired!.');
        }
        $this->_user = ClientUsers::findByPasswordResetTokenInactiveAccount($token);
        if (!$this->_user) {
            throw new Exception('Token expired');
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['password', 'required'],
            ['password', 'string'],
            [['password'], StrengthValidator::className(), 'preset' => 'fair', 'userAttribute' => 'username'],
            ['confirm_password', 'string'],
            ['confirm_password', 'required'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords do not match!"]
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword() {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->setStatus();
        
        $user->removePasswordResetToken();

        return $user->save(false);
    }

}
