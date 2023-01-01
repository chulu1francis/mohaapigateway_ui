<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\Countries;

/**
 * This is the model class for table "organisation_registration_details".
 *
 * @property int $id
 * @property int $organisation
 * @property int $country
 * @property string $number
 * @property string $registration_date
 * @property string $registration_expiry_date
 * @property int $years_of_experience
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property Countries $country0
 * @property Organisations $organisation0
 */
class OrganisationRegistrationDetails extends \yii\db\ActiveRecord {

    public $region;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'organisation_registration_details';
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
            [['organisation', 'country', 'number', 'registration_date', 'registration_expiry_date', 'region'], 'required'],
            [['organisation', 'country', 'years_of_experience', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['organisation', 'country', 'years_of_experience', 'created_at', 'updated_at'], 'integer'],
            //[['registration_date', 'registration_expiry_date'], 'safe'],
            ['registration_expiry_date', 'checkDates'],
            ['registration_date', 'checkRegistrationDate'],
            [['number'], 'string', 'max' => 45],
            [['number'], 'unique', 'message' => "Registration number exist already"],
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
            'number' => 'Registration number',
            'registration_date' => 'Registration date',
            'registration_expiry_date' => 'Registration expiry date',
            'years_of_experience' => 'Years of experience',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ];
    }

    public function checkDates() {
        if (!empty($this->registration_date) && !empty($this->registration_expiry_date)) {
            if ($this->registration_date > $this->registration_expiry_date) {
                $this->addError('registration_expiry_date', "Registration expiry date must be in the future");
            }
            if ($this->registration_expiry_date < date("Y-m-d")) {
                $this->addError('registration_expiry_date', "Your registration expired");
            }
        }
    }

    public function checkRegistrationDate() {
        if (!empty($this->registration_date)) {
            if ($this->registration_date > date("Y-m-d")) {
                $this->addError('registration_date', "Registration date cannot be in the future");
            }
        }
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

    public static function getYears($startDate, $endDate) {
        $d1 = new \DateTime($endDate);
        $d2 = new \DateTime($startDate);

        return $d2->diff($d1)->y;
    }

}
