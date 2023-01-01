<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "organisation_types".
 *
 * @property int $id
 * @property string $name
 * @property int $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property AauthUsers $createdBy
 * @property Organisations[] $organisations
 * @property AauthUsers $updatedBy
 */
class OrganisationTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organisation_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_by', 'created_at'], 'required'],
            [['name'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => AauthUsers::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => AauthUsers::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * Gets query for [[Organisations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisations()
    {
        return $this->hasMany(Organisations::class, ['type' => 'id']);
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
