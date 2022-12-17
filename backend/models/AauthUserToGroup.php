<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use backend\models\User;

/**
 * This is the model class for table "aauth_user_to_group".
 *
 * @property int $id
 * @property int $user
 * @property int $group
 * @property int|null $active
 * @property int $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property AauthGroup $group0
 * @property User $updatedBy
 * @property User $user0
 */
class AauthUserToGroup extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'aauth_user_to_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user', 'group'], 'required'],
            ['group', 'checkGroup'],
            ['group', 'unique', 'when' => function ($model) {
                    $userToGroup = !empty($model->user) && !empty($model->group) ? self::findOne(['user' => $model->user, "group" => $model->group]) : "";
                    return $model->isAttributeChanged('group') && !empty($userToGroup);
                }, 'message' => 'User is already attached to this group!'],
            [['user', 'group', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user', 'group', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['group'], 'exist', 'skipOnError' => true, 'targetClass' => AauthGroups::class, 'targetAttribute' => ['group' => 'id']],
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
            'user' => 'User',
            'group' => 'Group',
            'active' => 'Status',
            'created_by' => 'Assigned by',
            'updated_by' => 'Updated By',
            'created_at' => 'Date assigned',
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
     * Lets make sure the user is not attached to a group which is already their user group
     */
    public function checkGroup() {
        $user = !empty($this->user) && !empty($this->group) ? User::findOne(['group' => $this->group, "id" => $this->user]) : "";
        if (!empty($user)) {
            $this->addError('group', 'User is already attached to this user group!');
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
     * Gets query for [[Group0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup0() {
        return $this->hasOne(AauthGroups::class, ['id' => 'group']);
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

    public static function getActiveUserToGroupPermissions($user) {
        $permssions = "";
        $record = self::find()->cache(Yii::$app->params['cacheDuration'])
                ->where(["user" => $user, "active" => 1])
                ->asArray()
                ->orderBy(['id' => SORT_ASC])
                ->all();

        if (!empty($record)) {
            foreach ($record as $group) {
                $perms = AauthPermToGroup::find()->cache(Yii::$app->params['cacheDuration'])
                        ->select(['permission'])
                        ->where(['group' => $group])
                        ->asArray()
                        ->all();
                if (!empty($perms)) {
                    foreach ($perms as $permission) {
                        $permssions .= AauthPerm::findOne($permission['permission'])->name;
                    }
                }
            }
        }

        return $permssions;
    }

}
