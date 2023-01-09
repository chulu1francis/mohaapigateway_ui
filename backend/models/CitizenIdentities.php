<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "citizen_identities".
 *
 * @property int $id
 * @property string $nrc
 * @property string $surname
 * @property string $given_name
 * @property string|null $maiden_name
 * @property string|null $other_name
 * @property string|null $title
 * @property string $gender
 * @property string|null $residental_address
 * @property string|null $postal_address
 * @property string $nationality
 * @property string|null $other_nationality
 * @property string $chief
 * @property string $chiefs_provice
 * @property string $chiefs_district
 * @property string $date_of_birth
 * @property string|null $country_of_birth
 * @property string $town_of_birth
 * @property string|null $village_of_birth
 * @property string|null $place_of_birth_abroad
 * @property string $tribe
 * @property string|null $eye_color
 * @property float|null $height_in_cm
 * @property string|null $blood_group
 * @property string $race
 * @property string|null $marital_status
 * @property string|null $napsa
 * @property string|null $mobile_number
 * @property string|null $email
 * @property string|null $occupation
 * @property string|null $special_marks
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class CitizenIdentities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'citizen_identities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nrc', 'surname', 'given_name', 'gender', 'nationality', 'chief', 'chiefs_provice', 'chiefs_district', 'date_of_birth', 'town_of_birth', 'tribe', 'race'], 'required'],
            [['surname', 'given_name', 'maiden_name', 'other_name', 'residental_address', 'postal_address', 'nationality', 'other_nationality', 'chief', 'chiefs_provice', 'chiefs_district', 'country_of_birth', 'town_of_birth', 'village_of_birth', 'place_of_birth_abroad', 'tribe', 'eye_color', 'race', 'marital_status', 'napsa', 'occupation', 'special_marks'], 'string'],
            [['date_of_birth', 'created_at', 'updated_at'], 'safe'],
            [['height_in_cm'], 'number'],
            [['nrc'], 'string', 'max' => 45],
            [['title', 'gender', 'blood_group'], 'string', 'max' => 15],
            [['mobile_number'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nrc' => 'Nrc',
            'surname' => 'Surname',
            'given_name' => 'Given Name',
            'maiden_name' => 'Maiden Name',
            'other_name' => 'Other Name',
            'title' => 'Title',
            'gender' => 'Gender',
            'residental_address' => 'Residental Address',
            'postal_address' => 'Postal Address',
            'nationality' => 'Nationality',
            'other_nationality' => 'Other Nationality',
            'chief' => 'Chief',
            'chiefs_provice' => 'Chiefs Provice',
            'chiefs_district' => 'Chiefs District',
            'date_of_birth' => 'Date Of Birth',
            'country_of_birth' => 'Country Of Birth',
            'town_of_birth' => 'Town Of Birth',
            'village_of_birth' => 'Village Of Birth',
            'place_of_birth_abroad' => 'Place Of Birth Abroad',
            'tribe' => 'Tribe',
            'eye_color' => 'Eye Color',
            'height_in_cm' => 'Height In Cm',
            'blood_group' => 'Blood Group',
            'race' => 'Race',
            'marital_status' => 'Marital Status',
            'napsa' => 'Napsa',
            'mobile_number' => 'Mobile Number',
            'email' => 'Email',
            'occupation' => 'Occupation',
            'special_marks' => 'Special Marks',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
