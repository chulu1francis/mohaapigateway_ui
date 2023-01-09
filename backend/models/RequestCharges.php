<?php

namespace backend\models;

use Yii;
use backend\models\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "request_charges".
 *
 * @property int $id
 * @property float $charge
 * @property int $year
 * @property int $created_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class RequestCharges extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'request_charges';
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
            [['charge', 'year', 'created_by'], 'required'],
            [['charge'], 'number'],
            [['year', 'created_at', 'created_by', 'updated_by', 'updated_at'], 'default', 'value' => null],
            [['year', 'created_at', 'created_by', 'updated_by', 'updated_at'], 'integer'],
            [['year'], 'unique','message'=>"Request charge for this year exist already!"],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'charge' => 'Charge',
            'year' => 'Year',
            'created_at' => 'Created at',
            'created_by' => 'Created by',
            'updated_by' => 'Updated by',
            'updated_at' => 'Updated at',
        ];
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

    public static function getYearsList() {
        $currentYear = date('Y');
        $yearFrom = 2020;
        $yearsRange = range($currentYear,$yearFrom);
        return array_combine($yearsRange, $yearsRange);
    }

}
