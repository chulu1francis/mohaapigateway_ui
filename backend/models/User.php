<?php

namespace backend\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * This is the model class for table "aauth_users".
 *
 * @property int $id
 * @property int $group
 * @property string $first_name
 * @property string $last_name
 * @property string|null $phone
 * @property string $email
 * @property int $active
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string|null $verification_token
 * @property string|null $ip_address
 * @property int|null $login_attempts
 * @property int|null $updated_by
 * @property int|null $created_by
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $man_number
 * @property string|null $expiry_date
 * @property string $username By default, man nos are the usernames
 * @property string|null $last_login
 * @property string|null $other_name
 * @property string $title
 *
 * @property AauthGroups[] $aauthGroups
 * @property AauthGroups[] $aauthGroups0
 * @property AauthPermToGroup[] $aauthPermToGroups
 * @property AauthPermToGroup[] $aauthPermToGroups0
 * @property AauthPermToUser[] $aauthPermToUsers
 * @property AauthPermToUser[] $aauthPermToUsers0
 * @property AauthPermToUser[] $aauthPermToUsers1
 * @property AauthUserFiles[] $aauthUserFiles
 * @property AauthUserFiles[] $aauthUserFiles0
 * @property AauthUserFiles[] $aauthUserFiles1
 * @property AauthUserToGroup[] $aauthUserToGroups
 * @property AauthUserToGroup[] $aauthUserToGroups0
 * @property AauthUserToGroup[] $aauthUserToGroups1
 * @property AcreditationApplicationApprovals[] $acreditationApplicationApprovals
 * @property AcreditationApplicationApprovals[] $acreditationApplicationApprovals0
 * @property AuOrgans[] $auOrgans
 * @property AuOrgans[] $auOrgans0
 * @property Categories[] $categories
 * @property Categories[] $categories0
 * @property Countries[] $countries
 * @property Countries[] $countries0
 * @property Currencies[] $currencies
 * @property Currencies[] $currencies0
 * @property AauthGroups $group0
 * @property OfficialLanguages[] $officialLanguages
 * @property OfficialLanguages[] $officialLanguages0
 * @property OrganisationTypes[] $organisationTypes
 * @property OrganisationTypes[] $organisationTypes0
 * @property Regions[] $regions
 * @property Regions[] $regions0
 * @property SubCategories[] $subCategories
 * @property SubCategories[] $subCategories0
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface {

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_SUSPENDED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'aauth_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['group', 'first_name', 'last_name', 'email', 'active', 'auth_key', 'password_hash', 'username', 'title'], 'required'],
            [['group', 'active', 'login_attempts', 'updated_by', 'created_by', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['group', 'active', 'login_attempts', 'updated_by', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password_hash', 'verification_token', 'ip_address', 'other_name', 'title'], 'string'],
            [['expiry_date', 'last_login'], 'safe'],
            [['first_name', 'last_name', 'phone', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'string', 'max' => 45],
            [['phone'], PhoneInputValidator::className()],
            ['phone', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('phone_number');
                }, 'message' => 'Mobile number already in use!'],
            ['email', 'email', 'message' => "The email isn't correct!"],
            ['email', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('email');
                }, 'message' => 'Email already in use!'],
            [['image'], 'file',
                'extensions' => 'jpg, jpeg, png',
                'mimeTypes' => 'image/jpg,image/jpeg, image/png',
                'wrongExtension' => 'Only image files(jpeg,jpg,png) are allowed'],
            [['group'], 'exist', 'skipOnError' => true, 'targetClass' => AauthGroups::class, 'targetAttribute' => ['group' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'group' => 'Group',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'active' => 'Active',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'verification_token' => 'Verification Token',
            'ip_address' => 'Ip Address',
            'login_attempts' => 'Login Attempts',
            'updated_by' => 'Updated By',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'man_number' => 'Man Number',
            'expiry_date' => 'Expiry Date',
            'username' => 'By default, emails are the usernames',
            'last_login' => 'Last Login',
            'other_name' => 'Other Name',
            'title' => 'Title',
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
     * Gets query for [[AauthGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthGroups() {
        return $this->hasMany(AauthGroups::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AauthGroups0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthGroups0() {
        return $this->hasMany(AauthGroups::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AauthPermToGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToGroups() {
        return $this->hasMany(AauthPermToGroup::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AauthPermToGroups0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToGroups0() {
        return $this->hasMany(AauthPermToGroup::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AauthPermToUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToUsers() {
        return $this->hasMany(AauthPermToUser::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[AauthPermToUsers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToUsers0() {
        return $this->hasMany(AauthPermToUser::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AauthPermToUsers1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToUsers1() {
        return $this->hasMany(AauthPermToUser::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AauthUserFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUserFiles() {
        return $this->hasMany(AauthUserFiles::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[AauthUserFiles0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUserFiles0() {
        return $this->hasMany(AauthUserFiles::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AauthUserFiles1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUserFiles1() {
        return $this->hasMany(AauthUserFiles::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AauthUserToGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUserToGroups() {
        return $this->hasMany(AauthUserToGroup::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[AauthUserToGroups0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUserToGroups0() {
        return $this->hasMany(AauthUserToGroup::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AauthUserToGroups1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUserToGroups1() {
        return $this->hasMany(AauthUserToGroup::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AcreditationApplicationApprovals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcreditationApplicationApprovals() {
        return $this->hasMany(AcreditationApplicationApprovals::class, ['acreditation_officer' => 'id']);
    }

    /**
     * Gets query for [[AcreditationApplicationApprovals0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcreditationApplicationApprovals0() {
        return $this->hasMany(AcreditationApplicationApprovals::class, ['head_of_programs' => 'id']);
    }

    /**
     * Gets query for [[AuOrgans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuOrgans() {
        return $this->hasMany(AuOrgans::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AuOrgans0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuOrgans0() {
        return $this->hasMany(AuOrgans::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories() {
        return $this->hasMany(Categories::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Categories0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories0() {
        return $this->hasMany(Categories::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Countries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountries() {
        return $this->hasMany(Countries::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Countries0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountries0() {
        return $this->hasMany(Countries::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Currencies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencies() {
        return $this->hasMany(Currencies::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Currencies0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencies0() {
        return $this->hasMany(Currencies::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Group0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup0() {
        return $this->hasOne(AauthGroups::class, ['id' => 'group']);
    }

    /**
     * Gets query for [[OfficialLanguages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOfficialLanguages() {
        return $this->hasMany(OfficialLanguages::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[OfficialLanguages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOfficialLanguages0() {
        return $this->hasMany(OfficialLanguages::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[OrganisationTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationTypes() {
        return $this->hasMany(OrganisationTypes::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[OrganisationTypes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationTypes0() {
        return $this->hasMany(OrganisationTypes::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Regions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegions() {
        return $this->hasMany(Regions::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Regions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegions0() {
        return $this->hasMany(Regions::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[SubCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategories() {
        return $this->hasMany(SubCategories::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SubCategories0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategories0() {
        return $this->hasMany(SubCategories::class, ['updated_by' => 'id']);
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

    public static function isUserAllowedTo($right) {
        $session = Yii::$app->session;
        $rights = explode(',', $session['rights']);
        if (in_array($right, $rights)) {
            return true;
        }
        return false;
    }

    public static function getActiveUsers() {
        $query = static::find()
                ->where(['active' => self::STATUS_ACTIVE])
                ->orderBy(['man_number' => SORT_ASC])
                ->all();
        return ArrayHelper::map($query, 'id', 'man_number');
    }

    public static function getActiveUsersWithNames() {
        $query = static::find()
                ->select(["CONCAT(CONCAT(first_name,' ',last_name),'-',man_number) as name", 'id'])
                ->where(['active' => self::STATUS_ACTIVE])
                // ->andWhere(['NOT IN', 'first_name', 'Board'])
                ->orderBy(['username' => SORT_ASC])
                ->asArray()
                ->all();
        return ArrayHelper::map($query, 'id', 'name');
    }

    public function getFullName() {
        if (!empty($this->other_name)) {
            return ucfirst(strtolower($this->title)) . " " . ucfirst(strtolower($this->first_name)) . " " .
                    ucfirst(strtolower($this->other_name)) . " " . ucfirst(strtolower($this->last_name));
        }
        return ucfirst(strtolower($this->title)) . " " . ucfirst(strtolower($this->first_name)) . " " .
                ucfirst(strtolower($this->last_name));
    }

    /**
     * 
     * @return type array
     */
    public static function getFullNames() {
        $query = static::find()
                ->select(["CONCAT(CONCAT(first_name,' ',other_name),' ',last_name) as name", 'first_name'])
                ->where(['NOT IN', 'id', Yii::$app->user->id])
                ->orderBy(['id' => SORT_ASC])
                ->asArray()
                ->all();

        return \yii\helpers\ArrayHelper::map($query, 'first_name', 'name');
    }

    public static function getEmails() {
        $query = static::find()
                ->where(['NOT IN', 'id', Yii::$app->user->id])
                ->orderBy(['email' => SORT_ASC])
                ->all();
        return ArrayHelper::map($query, 'email', 'email');
    }

}
