<?php

namespace backend\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "aauth_perm_to_group".
 *
 * @property int $id
 * @property int $permission
 * @property int $group
 * @property int $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property AauthGroups $group0
 * @property AauthPerm $permission0
 * @property User $updatedBy
 */
class AauthPermToGroup extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'aauth_perm_to_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['permission', 'group', 'created_by', 'created_at'], 'required'],
            [['permission', 'group', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['permission', 'group', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['group'], 'exist', 'skipOnError' => true, 'targetClass' => AauthGroups::class, 'targetAttribute' => ['group' => 'id']],
            [['permission'], 'exist', 'skipOnError' => true, 'targetClass' => AauthPerm::class, 'targetAttribute' => ['permission' => 'id']],
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
            'group' => 'Group',
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

    public static function getGroupPermissions($groupid) {
        $rights = \backend\models\AauthPerm::find()
                ->joinWith('aauthPermToGroups')
                ->where([AauthPermToGroup::tableName() . '.group' => $groupid])
                ->orderBy(['name' => SORT_ASC])
                ->all();
        return \yii\helpers\ArrayHelper::map($rights, 'id', 'name');
    }

}
