<?php

namespace frontend\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use backend\models\Clients;
use backend\models\Configurations;

/**
 * This is the model class for table "client_users".
 *
 * @property int $id
 * @property int $client
 * @property string $first_name
 * @property string $last_name
 * @property string|null $other_names
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string|null $password_reset_token
 * @property string|null $verification_token
 * @property int $active
 * @property string $username
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Clients $client0
 */
class ClientUsers extends ActiveRecord implements IdentityInterface {

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'client_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['client', 'first_name', 'last_name', 'email', 'password_hash', 'auth_key', 'username'], 'required'],
            [['client', 'active', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['client', 'active', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['first_name', 'last_name', 'other_names', 'password_hash', 'verification_token', 'username'], 'string'],
            [['email', 'password_reset_token'], 'string', 'max' => 255],
            ['client', 'checkUsers','on'=>"onSubmit"],
            [['auth_key'], 'string', 'max' => 45],
            ['email', 'email', 'message' => "The email isn't correct!"],
            ['email', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('email');
                }, 'message' => 'Email already in use!'],
            [['client'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::class, 'targetAttribute' => ['client' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'client' => 'Client',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'other_names' => 'Other names',
            'email' => 'Email',
            'password_hash' => 'Password',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password reset token',
            'verification_token' => 'Verification token',
            'active' => 'Active',
            'username' => 'Username',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'created_by' => 'Created by',
            'updated_by' => 'Updated by',
        ];
    }

    /**
     * Check if user has selected a permission
     */
    public function checkUsers() {
        if (!empty($this->client)) {
            $users = ClientUsers::find()->where(['client' => $this->client])->count();
            $allowedUsers = Configurations::findOne(['name' => 'ALLOWED_CLIENT_USERS']);
            $count = !empty($allowedUsers) ? $allowedUsers->value : 2;

            if ($users >= $count) {
                $this->addError('client', 'Client has reached the allowed client user limit of ' . $count);
            }
        }
    }

    /**
     * Gets query for [[Client0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient0() {
        return $this->hasOne(Clients::class, ['id' => 'client']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::find()->where(['id' => $id, 'active' => self::STATUS_ACTIVE])->one();
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'active' => self::STATUS_ACTIVE]);
    }

    public static function findById($id) {
        return static::findOne(['id' => $id]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'active' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findByPasswordResetTokenInactiveAccount($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'active' => self::STATUS_INACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
                    'verification_token' => $token,
                    'active' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password . $this->auth_key, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password . $this->auth_key);
    }

    public function setStatus() {
        $this->active = self::STATUS_ACTIVE;
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generateEmailVerificationToken() {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public static function getEmails() {
        $query = static::find()
                ->orderBy(['email' => SORT_ASC])
                ->all();
        return ArrayHelper::map($query, 'email', 'email');
    }

}
