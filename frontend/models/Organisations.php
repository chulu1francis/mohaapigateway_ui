<?php

namespace frontend\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use borales\extensions\phoneInput\PhoneInputValidator;
use \backend\models\Countries;
use backend\models\OfficialLanguages;
use backend\models\OrganisationTypes;

/**
 * This is the model class for table "organisations".
 *
 * @property int $id
 * @property int $country
 * @property int $official_language
 * @property int $type
 * @property string $name
 * @property string|null $acronym
 * @property string $postal_address
 * @property string $postal_code
 * @property string $town
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string|null $verification_token
 * @property int|null $login_attempts
 * @property string|null $last_login
 * @property int $created_at
 * @property int|null $updated_at
 * @property string $scope_of_operation
 * @property string $website
 * @property string $mobile
 * @property int|null $active
 *
 * @property AccreditationApplications[] $accreditationApplications
 * @property Countries $country0
 * @property ObserverStatusApplications[] $observerStatusApplications
 * @property OfficialLanguages $officialLanguage
 * @property OrganisationAreaOfExpertise[] $organisationAreaOfExpertises
 * @property OrganisationContactPersons[] $organisationContactPersons
 * @property OrganisationRegistrationDetails[] $organisationRegistrationDetails
 * @property OrganisationTypes $type0
 */
class Organisations extends ActiveRecord implements IdentityInterface {

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_SUSPENDED = 2;
    public $region;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'organisations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['country','region', 'official_language', 'type', 'name', 'postal_address', 'postal_code', 'town', 'email', 'auth_key', 'password_hash', 'scope_of_operation', 'website', 'mobile'], 'required'],
            [['country', 'official_language', 'type', 'login_attempts', 'created_at', 'updated_at', 'active'], 'default', 'value' => null],
            [['country', 'official_language', 'type', 'login_attempts', 'created_at', 'updated_at', 'active'], 'integer'],
            [['name', 'postal_address', 'town', 'email', 'verification_token', 'scope_of_operation', 'website'], 'string'],
            [['last_login'], 'safe'],
            [['acronym', 'auth_key'], 'string', 'max' => 45],
            [['postal_code'], 'string', 'max' => 20],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            ['website', 'url','defaultScheme' => 'http'],
            [['logo'], 'file',
                'extensions' => 'jpg, jpeg, png',
                'mimeTypes' => 'image/jpg,image/jpeg, image/png',
                'wrongExtension' => 'Only image files(jpeg,jpg,png) are allowed'],
            [['mobile'], PhoneInputValidator::className()],
            ['name', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('name');
                }, 'message' => 'Organisation exist already!'],
            ['email', 'email', 'message' => "The email isn't correct!"],
            ['email', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('email');
                }, 'message' => 'Email already in use!'],
            [['country'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['country' => 'id']],
            [['official_language'], 'exist', 'skipOnError' => true, 'targetClass' => OfficialLanguages::class, 'targetAttribute' => ['official_language' => 'id']],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => OrganisationTypes::class, 'targetAttribute' => ['type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'country' => 'Country',
            'official_language' => 'Official language',
            'type' => 'Type',
            'name' => 'Name',
            'acronym' => 'Acronym',
            'postal_address' => 'Postal address',
            'postal_code' => 'Postal code',
            'town' => 'City/Town',
            'email' => 'Email',
            'auth_key' => 'Auth key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'verification_token' => 'Verification token',
            'login_attempts' => 'Login attempts',
            'last_login' => 'Last login',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'scope_of_operation' => 'Scope of operation',
            'website' => 'Website',
            'mobile' => 'Mobile',
            'active' => 'Active',
        ];
    }

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
     * Gets query for [[AccreditationApplications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccreditationApplications() {
        return $this->hasMany(AccreditationApplications::class, ['organisation' => 'id']);
    }

    /**
     * Gets query for [[Country0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry0() {
        return $this->hasOne(Countries::class, ['id' => 'country']);
    }

    /**
     * Gets query for [[ObserverStatusApplications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObserverStatusApplications() {
        return $this->hasMany(ObserverStatusApplications::class, ['organisation' => 'id']);
    }

    /**
     * Gets query for [[OfficialLanguage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOfficialLanguage() {
        return $this->hasOne(OfficialLanguages::class, ['id' => 'official_language']);
    }

    /**
     * Gets query for [[OrganisationAreaOfExpertises]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationAreaOfExpertises() {
        return $this->hasMany(OrganisationAreaOfExpertise::class, ['organisation' => 'id']);
    }

    /**
     * Gets query for [[OrganisationContactPersons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationContactPersons() {
        return $this->hasMany(OrganisationContactPersons::class, ['organisation' => 'id']);
    }

    /**
     * Gets query for [[OrganisationRegistrationDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationRegistrationDetails() {
        return $this->hasMany(OrganisationRegistrationDetails::class, ['organisation' => 'id']);
    }

    /**
     * Gets query for [[Type0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType0() {
        return $this->hasOne(OrganisationTypes::class, ['id' => 'type']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::find()->cache(3600)->where(['id' => $id, 'active' => self::STATUS_ACTIVE])->one();
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

}
