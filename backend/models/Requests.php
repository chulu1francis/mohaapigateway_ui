<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "requests".
 *
 * @property int $id
 * @property int $client
 * @property string $request
 * @property int $status 200=Success, 201=failed
 * @property float $amount Amount charged
 * @property int $payment_status
 * @property string|null $path
 * @property string $source_ip
 * @property string|null $source_agent
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $proof_of_payment
 *
 * @property Clients $client0
 */
class Requests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client', 'request', 'amount', 'source_ip', 'created_at'], 'required'],
            [['client', 'status', 'payment_status'], 'default', 'value' => null],
            [['client', 'status', 'payment_status'], 'integer'],
            [['request', 'path', 'source_ip', 'source_agent'], 'string'],
            [['amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['proof_of_payment'], 'string', 'max' => 255],
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
            'request' => 'Request',
            'status' => 'Status',
            'amount' => 'Amount charged',
            'payment_status' => 'Payment status',
            'path' => 'Path',
            'source_ip' => 'Source ip',
            'source_agent' => 'Source agent',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'proof_of_payment' => 'Proof of payment',
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
}
