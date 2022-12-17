<?php

namespace backend\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "departments".
 *
 * @property int $id
 * @property int $school
 * @property string $name
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $head
 * @property string|null $code
 *
 * @property AauthUsers[] $aauthUsers
 * @property AauthUsers $createdBy
 * @property AauthUsers $head0
 * @property Programs[] $programs
 * @property Schools $school0
 * @property AauthUsers $updatedBy
 */
class Departments extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'departments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['school', 'name'], 'required'],
            [['school', 'created_by', 'updated_by', 'created_at', 'updated_at', 'head'], 'default', 'value' => null],
            [['school', 'created_by', 'updated_by', 'created_at', 'updated_at', 'head'], 'integer'],
            [['name'], 'string'],
            [['code'], 'string', 'max' => 45],
            ['code', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('code');
                }, 'message' => 'Department code already in use!'],
            ['name', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('name');
                }, 'message' => 'Department name exist already!'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => AauthUsers::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => AauthUsers::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['head'], 'exist', 'skipOnError' => true, 'targetClass' => AauthUsers::class, 'targetAttribute' => ['head' => 'id']],
            [['school'], 'exist', 'skipOnError' => true, 'targetClass' => Schools::class, 'targetAttribute' => ['school' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'school' => 'School',
            'name' => 'Name',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'head' => 'Head',
            'code' => 'Code',
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
     * Gets query for [[AauthUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUsers() {
        return $this->hasMany(AauthUsers::class, ['department' => 'id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(AauthUsers::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Head0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHead0() {
        return $this->hasOne(AauthUsers::class, ['id' => 'head']);
    }

    /**
     * Gets query for [[Programs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrograms() {
        return $this->hasMany(Programs::class, ['department' => 'id']);
    }

    /**
     * Gets query for [[School0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchool0() {
        return $this->hasOne(Schools::class, ['id' => 'school']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(AauthUsers::class, ['id' => 'updated_by']);
    }

    public static function getDepartments() {
        $users = self::find()
                ->cache(Yii::$app->params['cacheDuration'])
                ->orderBy(['name' => SORT_ASC])
                ->asArray()
                ->all();
        $list = \yii\helpers\ArrayHelper::map($users, 'id', 'name');
        return $list;
    }

}
