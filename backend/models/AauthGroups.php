<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "aauth_groups".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 *
 * @property AauthPermToGroup[] $aauthPermToGroups
 * @property AauthUserToGroup[] $aauthUserToGroups
 * @property AauthUser[] $aauthUsers
 * @property AauthUser $createdBy
 * @property AauthUser $updatedBy
 */
class AauthGroups extends \yii\db\ActiveRecord {

    public $permissions;

    /**
     * {@inheritdoc}rights
     */
    public static function tableName() {
        return 'aauth_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'permissions'], 'required'],
            [['name', 'description'], 'string'],
            ['permissions', 'checkIsArray'],
            ['name', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('name');
                }, 'message' => 'User group exist already!'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
            'name' => 'Group name',
            'description' => 'Description',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'created_by' => 'Created by',
            'updated_by' => 'Updated by',
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
     * Check if user has selected a permission
     */
    public function checkIsArray() {
        if (!is_array($this->permissions)) {
            $this->addError('permissions', 'Please select one option!');
        }
    }

    /**
     * Gets query for [[AauthPermToGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToGroups() {
        return $this->hasMany(AauthPermToGroup::class, ['group' => 'id']);
    }

    /**
     * Gets query for [[AauthUserToGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUserToGroups() {
        return $this->hasMany(AauthUserToGroup::class, ['group' => 'id']);
    }

    /**
     * Gets query for [[AauthUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUsers() {
        return $this->hasMany(User::class, ['group' => 'id']);
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

    /**
     * @return array
     */
    public static function getGroupList() {
        $groups = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = ArrayHelper::map($groups, 'name', 'name');
        return $list;
    }

    public static function getGroups() {
        $groups = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = ArrayHelper::map($groups, 'id', 'name');
        return $list;
    }

}
