<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "currencies".
 *
 * @property int $id
 * @property string $name
 * @property string $iso_code
 * @property int $created_by
 * @property int $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 *
 * @property AccreditationApplications[] $accreditationApplications
 * @property AauthUsers $createdBy
 * @property AauthUsers $updatedBy
 */
class Currencies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'iso_code', 'created_by', 'created_at'], 'required'],
            [['name'], 'string'],
            [['created_by', 'created_at', 'updated_by', 'updated_at'], 'default', 'value' => null],
            [['created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['iso_code'], 'string', 'max' => 15],
            [['iso_code'], 'unique'],
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
            'iso_code' => 'Iso Code',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AccreditationApplications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccreditationApplications()
    {
        return $this->hasMany(AccreditationApplications::class, ['currency' => 'id']);
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
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(AauthUsers::class, ['id' => 'updated_by']);
    }
    
     public static function getCurrencies() {
        $campuses = self::find()->orderBy(['name' => SORT_ASC])->all();
        return ArrayHelper::map($campuses, 'id', 'iso_code');
    }
}
