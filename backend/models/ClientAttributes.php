<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "client_attributes".
 *
 * @property int $id
 * @property int $client
 * @property string $attribute
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Clients $client0
 */
class ClientAttributes extends \yii\db\ActiveRecord {

    public $attributes;

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
        return 'client_attributes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['client', 'attribute', 'attributes'], 'required'],
            [['client', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['client', 'created_by', 'updated_by'], 'integer'],
            [['attribute'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['client'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::class, 'targetAttribute' => ['client' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'client' => 'Client',
            'attribute' => 'Attribute',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Client0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient0() {
        return $this->hasOne(Clients::class, ['id' => 'client']);
    }

}
