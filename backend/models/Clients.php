<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\User;
use borales\extensions\phoneInput\PhoneInputValidator;
use yii\helpers\ArrayHelper;
use frontend\models\ClientUsers;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $contact_person_first_name
 * @property string|null $phone
 * @property string|null $email
 * @property string $username
 * @property string $secret_key
 * @property string $auth_key
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string $can_pay Client can pay for accessing the system or not
 *
 * @property ClientAttributes[] $clientAttributes
 * @property ClientIpWhitelist[] $clientIpWhitelists
 * @property ClientUsers[] $clientUsers
 * @property Requests[] $requests
 */
class Clients extends \yii\db\ActiveRecord {

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
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'address', 'contact_person_first_name', 'username', 'secret_key', 'auth_key', 'active', 'can_pay', 'email', 'contact_person_last_name'], 'required'],
            [['name', 'address', 'contact_person_first_name', 'email', 'auth_key', 'contact_person_last_name'], 'string'],
            [['active', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['active', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            ['name', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('name');
                }, 'message' => 'Client exist already!'],
            ['email', 'email', 'message' => "The email isn't correct!"],
            ['email', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('email');
                }, 'message' => 'Email already in use!'],
            [['phone'], PhoneInputValidator::className()],
            [['username', 'secret_key'], 'string', 'max' => 255],
            [['can_pay'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'contact_person_first_name' => 'Contact person first name',
            'contact_person_last_name' => 'Contact person last name',
            'phone' => 'Phone',
            'email' => 'Email',
            'username' => 'Username',
            'secret_key' => 'Secret key',
            'auth_key' => 'Auth Key',
            'active' => 'Active',
            'status' => 'Status',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'created_by' => 'Created by',
            'updated_by' => 'Updated by',
            'can_pay' => 'Can pay',
            'amount' => 'Charge',
        ];
    }

    /**
     * Gets query for [[ClientAttributes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientAttributes() {
        return $this->hasMany(ClientAttributes::class, ['client' => 'id']);
    }

    /**
     * Gets query for [[ClientIpWhitelists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientIpWhitelists() {
        return $this->hasMany(ClientIpWhitelist::class, ['client' => 'id']);
    }

    /**
     * Gets query for [[ClientUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientUsers() {
        return $this->hasMany(ClientUsers::class, ['client' => 'id']);
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests() {
        return $this->hasMany(Requests::class, ['client' => 'id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public static function getClientsByName() {
        $groups = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = ArrayHelper::map($groups, 'name', 'name');
        return $list;
    }
    
      public static function getClients() {
        $groups = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = ArrayHelper::map($groups, 'id', 'name');
        return $list;
    }

}
