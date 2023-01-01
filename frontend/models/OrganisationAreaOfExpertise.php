<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\SubCategories;

/**
 * This is the model class for table "organisation_area_of_expertise".
 *
 * @property int $id
 * @property int $organisation
 * @property int $sub_category
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property Organisations $organisation0
 * @property SubCategories $subCategory
 */
class OrganisationAreaOfExpertise extends \yii\db\ActiveRecord {

    public $category;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'organisation_area_of_expertise';
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
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['organisation', 'sub_category', 'category'], 'required'],
            [['organisation', 'sub_category', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['organisation', 'sub_category', 'created_at', 'updated_at'], 'integer'],
            ['sub_category', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('sub_category') &&
                    !empty(self::findOne(['sub_category' => $model->sub_category, 'organisation' => $model->organisation]));
                }, 'message' => 'Sub category exist already'],
            [['organisation'], 'exist', 'skipOnError' => true, 'targetClass' => Organisations::class, 'targetAttribute' => ['organisation' => 'id']],
            [['sub_category'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategories::class, 'targetAttribute' => ['sub_category' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'organisation' => 'Organisation',
            'sub_category' => 'Sub Category',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Organisation0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisation0() {
        return $this->hasOne(Organisations::class, ['id' => 'organisation']);
    }

    /**
     * Gets query for [[SubCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategory() {
        return $this->hasOne(SubCategories::class, ['id' => 'sub_category']);
    }

}
