<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "aauth_perm_to_user".
 *
 * @property int $id
 * @property int $permission
 * @property int $user
 * @property int|null $active
 * @property string|null $expiry_date
 * @property int $created_by
 * @property int $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property AauthPerm $permission0
 * @property User $updatedBy
 * @property User $user0
 */
class AauthPermToUser extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'aauth_perm_to_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['permission', 'user'], 'required'],
            ['permission', 'checkPermission'],
            ['permission', 'unique', 'when' => function ($model) {
                    $userPermission = !empty($model->user) && !empty($model->permission) ? self::findOne(['user' => $model->user, "permission" => $model->permission]) : "";
                    return $model->isAttributeChanged('permission') && !empty($userPermission);
                }, 'message' => 'User already has this permission!'],
            [['permission', 'user', 'active', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'default', 'value' => null],
            [['permission', 'user', 'active', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['expiry_date'], 'safe'],
            [['permission'], 'exist', 'skipOnError' => true, 'targetClass' => AauthPerm::class, 'targetAttribute' => ['permission' => 'id']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user' => 'id']],
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
            'permission' => 'Permission',
            'user' => 'User',
            'active' => 'Status',
            'expiry_date' => 'Expiry date',
            'created_by' => 'Assigned by',
            'created_at' => 'Date assigned',
            'updated_by' => 'Updated by',
            'updated_at' => 'Updated at',
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
     * Lets make sure the user is not assigned a permission which is already part of their user group
     */
    public function checkPermission() {
        $user = !empty($this->user) ? User::findOne(["id" => $this->user]) : "";
        if (!empty($user) & !empty($this->permission)) {
            $userPermission = AauthPermToGroup::findOne(['permission' => $this->permission, 'group' => $user->group]);
            if (!empty($userPermission)) {
                $this->addError('permission', 'User is already assigned this permission via their current user group!');
            }
        }
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
     * Gets query for [[Permission0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPermission0() {
        return $this->hasOne(AauthPerm::class, ['id' => 'permission']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0() {
        return $this->hasOne(User::class, ['id' => 'user']);
    }

    public static function getPermissionExpiry() {
        return date('Y-m-d H:i:s', (strtotime('+' . \Yii::$app->params['specialPermissionExpiry'] . 'hours', strtotime(date("Y-m-d H:i:s")))));
    }

    public static function getSpecialPermissions($user) {
        $currentDate = date('Y-m-d H:i:s');
        $rights = AauthPerm::find()
                ->leftJoin('aauth_perm_to_user', AauthPerm::tableName() . '.id=' . AauthPermToUser::tableName() . '.permission')
                ->where([AauthPermToUser::tableName() . '.user' => $user])
                ->andWhere(['>=', AauthPermToUser::tableName() . '.expiry_date', $currentDate])
                ->orderBy(['name' => SORT_ASC])
                ->all();

        return \yii\helpers\ArrayHelper::map($rights, 'id', 'name');
    }

}
