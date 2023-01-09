<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "available_attributes".
 *
 * @property int $id
 * @property string $attribute
 * @property string $name
 */
class AvailableAttributes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'available_attributes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attribute', 'name'], 'required'],
            [['attribute', 'name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attribute' => 'Attribute',
            'name' => 'Name',
        ];
    }
    
      public static function getAvailableAttributes() {
        return static::find()->cache(Yii::$app->params['cacheDuration'])->orderBy('attribute')->all();
    }
}
