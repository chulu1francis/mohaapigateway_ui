<?php

use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use borales\extensions\phoneInput\PhoneInput;
use backend\models\OfficialLanguages;
use backend\models\OrganisationTypes;
use backend\models\Regions;

/* @var $this yii\web\View */
/* @var $model common\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$model->region = backend\models\Countries::findOne($model->country)->region;
$form = ActiveForm::begin(
                [
        ]);
?>
<div class="row">

    <div class="col-lg-12">
        <ol>
            <li class="falcon-card-color text-danger">Email is used for login. Changing it means you use the new email address to login!</li>
        </ol>
    </div>
    <div class="col-lg-6">

        <?=
        $form->field($model, 'name'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Organisation name'])
        ?>

        <?=
        $form->field($model, 'email', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
            ],
        ])->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Email address'])
        ?>
        <?=
        $form->field($model, 'type', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
        ])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(OrganisationTypes::find()->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Select organisation type', 'id' => 'org_type',
            // 'style' => "font-size:10px;"
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        <?php
        echo "<label class='' style='font-weight:normal;margin-bottom:10px;' for='phone1'>Mobile phone number <span class='text-danger'>*</span></label>";
        echo $form->field($model, 'mobile', [
            'labelOptions' => [
                'class' => 'text-dark',
                'style' => "font-weight:normal;",
            ],
        ])->widget(PhoneInput::className(), [
            'options' => ['style' => 'width:275px;'],
            'jsOptions' => [
                'allowExtensions' => true,
                'preferredCountries' => ['ZM'],
            ]
                ], ['maxlength' => true, 'id' => "phone_id"])->label(false);
        ?> 
        <?=
        $form->field($model, 'region', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
        ])->widget(Select2::classname(), [
            'data' => Regions::getRegions(),
            'options' => ['placeholder' => 'Select region', 'id' => 'region_id'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label("Region");
        ?>
        <?=
        $form->field($model, 'town', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
            ],
        ])->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Organisation city/town'])
        ?>
        <?=
        $form->field($model, 'postal_address', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
            ],
        ])->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Organisation address'])
        ?>


    </div>
    <div class="col-lg-6">

        <?=
        $form->field($model, 'acronym'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => '',
                'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Organisation acronyms'])
        ?>
        <?=
        $form->field($model, 'website', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
            ],
        ])->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Organisation website'])
        ?>
        <?=
        $form->field($model, 'scope_of_operation', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
        ])->widget(Select2::classname(), [
            'data' => Yii::$app->params['scope_of_operations'],
            'options' => ['placeholder' => 'Select scope of operation', 'id' => 'scope_of_op',
            // 'style' => "font-size:10px;"
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        <?=
        $form->field($model, 'official_language', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
        ])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(OfficialLanguages::find()->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Select official language', 'id' => 'language',
            // 'style' => "font-size:10px;"
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>

        <?php
        echo Html::hiddenInput('selected_id', $model->isNewRecord ? '' : $model->country, ['id' => 'selected_id']);

        echo $form->field($model, 'country', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
        ])->widget(DepDrop::classname(), [
            'type' => DepDrop::TYPE_SELECT2,
            'options' => ['id' => 'country_id', 'custom' => true, 'placeholder' => 'Select country'],
            'pluginOptions' => [
                'depends' => ['region_id'],
                'initialize' => $model->isNewRecord ? false : true,
                'placeholder' => 'Select country',
                'url' => Url::to(['/site/countries']),
                'params' => ['selected_id'],
            ]
        ]);
        ?>
        <?=
        $form->field($model, 'postal_code', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
            ],
        ])->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Organisation postal code'])
        ?>


    </div>

    <div class="col-lg-12">
        <?= Html::submitButton('Update', ['class' => 'btn btn-success btn-md font-weight-bold font-size:18px;']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

