<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "available_endpoints".
 *
 * @property int $id
 * @property string $endpoint Actual api endpoint
 * @property string $search_key Key used to filter what client is allowed to access
 * @property string $name Name shown on the ui
 */
class AvailableEndpoints extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'available_endpoints';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['endpoint', 'search_key', 'name'], 'required'],
            [['endpoint', 'search_key'], 'string'],
            [['name'], 'string', 'max' => 90],
            [['search_key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'endpoint' => 'Endpoint',
            'search_key' => 'Search key',
            'name' => 'Name',
        ];
    }

    public static function getAvailableEndpoints() {
        return static::find()->cache(Yii::$app->params['cacheDuration'])->orderBy(['search_key'=>SORT_DESC])->all();
    }

}
