<?php

namespace backend\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "campuses".
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string|null $address
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AauthUsers $createdBy
 * @property Hostels[] $hostels
 * @property Schools[] $schools
 * @property AauthUsers $updatedBy
 */
class Campuses extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'campuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['name', 'code', 'address'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            ['code', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('code');
                }, 'message' => 'Campus code already in use!'],
            ['name', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('name');
                }, 'message' => 'Campus name exist already!'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => AauthUsers::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => AauthUsers::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'address' => 'Address',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(AauthUsers::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Hostels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHostels() {
        return $this->hasMany(Hostels::class, ['campus' => 'id']);
    }

    /**
     * Gets query for [[Schools]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchools() {
        return $this->hasMany(Schools::class, ['campus' => 'id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(AauthUsers::class, ['id' => 'updated_by']);
    }

}
