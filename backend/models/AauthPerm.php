<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "aauth_perms".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $group CREATE,VIEW,UPDATE,DELETE
 *
 * @property AauthPermToGroup[] $aauthPermToGroups
 * @property AauthPermToUser[] $aauthPermToUsers
 */
class AauthPerm extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'aauth_perms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['name', 'description', 'group'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'group' => 'MANAGE,VIEW',
        ];
    }

    /**
     * Gets query for [[AauthPermToGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToGroups() {
        return $this->hasMany(AauthPermToGroup::class, ['permission' => 'id']);
    }

    /**
     * Gets query for [[AauthPermToUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToUsers() {
        return $this->hasMany(AauthPermToUser::class, ['permission' => 'id']);
    }
    

    public static function seedPermissions() {
        //Please add rights to the end of the $rights array in below format
        //Permission => Group
        $permissions = [
            'Manage users' => "MANAGE",
            'View users' => "VIEW",
            'Manage groups' => "MANAGE",
            'View groups' => "VIEW",
            'Manage user to group' => "MANAGE",
            'Assign permission to user' => "MANAGE",
        ];

        $count = 0;
        foreach ($permissions as $permission => $group) {
            if (empty(self::findOne(["name" => $permission]))) {
                $model = new AauthPerm();
                $model->name = $permission;
                $model->group = $group;
                if ($model->save(false)) {
                    $count++;
                }
            }
        }
        echo "Inserted $count permissions into aauth_perms table<br>";
    }

    /**
     * Get all permissions
     * @return type
     */
    public static function getPermissions() {
        return static::find()->cache(Yii::$app->params['cacheDuration'])->orderBy('group')->all();
    }
    
     public static function getPerms() {
        $groups = self::find()->cache(Yii::$app->params['cacheDuration'])->orderBy(['name' => SORT_ASC])->all();
        $list = ArrayHelper::map($groups, 'id', 'name');
        return $list;
    }

}
