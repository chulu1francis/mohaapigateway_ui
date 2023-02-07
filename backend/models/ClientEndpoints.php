<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "client_endpoints".
 *
 * @property int $id
 * @property int $client
 * @property string $endpoint
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Clients $client0
 * @property AauthUsers $createdBy
 * @property AauthUsers $updatedBy
 */
class ClientEndpoints extends ActiveRecord
{
     public $endpoints;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_endpoints';
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
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client', 'endpoint','endpoints'], 'required'],
            [['client', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['client', 'created_by', 'updated_by'], 'integer'],
            [['endpoint'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => AauthUsers::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => AauthUsers::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['client'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::class, 'targetAttribute' => ['client' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client' => 'Client',
            'endpoint' => 'Endpoint',
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
    public function getClient0()
    {
        return $this->hasOne(Clients::class, ['id' => 'client']);
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
}
