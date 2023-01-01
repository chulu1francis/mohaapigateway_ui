<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property int $id
 * @property int $region
 * @property string $name
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 *
 * @property AauthUsers $createdBy
 * @property OrganisationContactPersons[] $organisationContactPersons
 * @property OrganisationRegistrationDetails[] $organisationRegistrationDetails
 * @property Organisations[] $organisations
 * @property Regions $region0
 * @property AauthUsers $updatedBy
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region', 'name', 'created_at', 'created_by'], 'required'],
            [['region', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['region', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => AauthUsers::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => AauthUsers::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['region'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['region' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region' => 'Region',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(AauthUsers::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[OrganisationContactPersons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationContactPersons()
    {
        return $this->hasMany(OrganisationContactPersons::class, ['country' => 'id']);
    }

    /**
     * Gets query for [[OrganisationRegistrationDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationRegistrationDetails()
    {
        return $this->hasMany(OrganisationRegistrationDetails::class, ['country' => 'id']);
    }

    /**
     * Gets query for [[Organisations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisations()
    {
        return $this->hasMany(Organisations::class, ['country' => 'id']);
    }

    /**
     * Gets query for [[Region0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion0()
    {
        return $this->hasOne(Regions::class, ['id' => 'region']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(AauthUsers::class, ['id' => 'updated_by']);
    }
}
