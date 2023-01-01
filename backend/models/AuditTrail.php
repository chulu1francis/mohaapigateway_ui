<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\User;

/**
 * This is the model class for table "audit_trail_hea".
 *
 * @property int $id
 * @property int $user
 * @property string $action
 * @property int $date
 * @property string $ip_address
 * @property string $user_agent
 *
 * @property HeaUser $user0
 */
class AuditTrail extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'audit_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user', 'action'], 'required'],
            [['user', 'date'], 'integer'],
            [['action'], 'string'],
            [['ip_address', 'user_agent'], 'string', 'max' => 255],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user' => 'User',
            'action' => 'Action',
            'date' => 'Date',
            'ip_address' => 'IP Address',
            'user_agent' => 'User Agent',
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                ],
            ],
        ];
    }

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0() {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    /**
     * Function for logging audit trails
     * @param type $action
     * @param type $extraData
     */
    public static function logTrail($action, $extraData = '') {
        $audit = new AuditTrail();
        $audit->user = Yii::$app->user->id;
        $audit->action = $action;
        $audit->extra_data = $extraData;
        $audit->ip_address = Yii::$app->request->getUserIP();
        $audit->user_agent = Yii::$app->request->getUserAgent();
        $audit->save();
    }

    /**
     * Function for logging audit trails for not logged in users
     * @param type $action
     * @param type $extraData
     */
    public static function logTrailUser($action, $extraData = '',$user) {
        $audit = new AuditTrail();
        $audit->user = $user;
        $audit->action = $action;
        $audit->extra_data = $extraData;
        $audit->ip_address = Yii::$app->request->getUserIP();
        $audit->user_agent = Yii::$app->request->getUserAgent();
        $audit->save();
    }

}
