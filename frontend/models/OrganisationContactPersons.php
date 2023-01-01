<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\Countries;
use borales\extensions\phoneInput\PhoneInputValidator;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "organisation_contact_persons".
 *
 * @property int $id
 * @property int $organisation
 * @property int $country
 * @property string $title
 * @property string $formal_title
 * @property string $first_name
 * @property string $last_name
 * @property string|null $other_names
 * @property string $department
 * @property string $telephone
 * @property string $mobile
 * @property string|null $fax
 * @property string|null $whatsapp_number
 * @property string|null $email
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property Countries $country0
 * @property Organisations $organisation0
 */
class OrganisationContactPersons extends \yii\db\ActiveRecord {

    public $region;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'organisation_contact_persons';
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
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['organisation', 'country', 'email', 'title', 'formal_title', 'first_name', 'last_name', 'department', 'telephone', 'mobile', 'region'], 'required'],
            [['organisation', 'country', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['organisation', 'country', 'created_at', 'updated_at'], 'integer'],
            [['formal_title', 'first_name', 'last_name', 'other_names', 'department', 'telephone', 'fax', 'email'], 'string'],
            [['title'], 'string', 'max' => 15],
            ['fax', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('fax');
                }, 'message' => 'Fax number already in use!'],
            [['mobile', 'whatsapp_number'], PhoneInputValidator::className()],
            ['telephone', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('telephone');
                }, 'message' => 'Telephone number already in use!'],
            [['whatsapp_number'], 'unique'],
            ['email', 'email', 'message' => "The email isn't correct!"],
            ['email', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('email');
                }, 'message' => 'Email already in use!'],
            [['country'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['country' => 'id']],
            [['organisation'], 'exist', 'skipOnError' => true, 'targetClass' => Organisations::class, 'targetAttribute' => ['organisation' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'organisation' => 'Organisation',
            'country' => 'Country',
            'title' => 'Title',
            'formal_title' => 'Formal Title',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'other_names' => 'Other Names',
            'department' => 'Department',
            'telephone' => 'Telephone',
            'mobile' => 'Mobile',
            'fax' => 'Fax',
            'whatsapp_number' => 'Whatsapp Number',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
     * Gets query for [[Organisation0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisation0() {
        return $this->hasOne(Organisations::class, ['id' => 'organisation']);
    }

}
