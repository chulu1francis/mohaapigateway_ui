<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use borales\extensions\phoneInput\PhoneInput;
use backend\models\Regions;


/* @var $this yii\web\View */
/* @var $model common\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
if (!empty($model->country)) {
    $model->country = $model->country;
    $model->region = backend\models\Countries::findOne($model->country)->region;
}

$form = ActiveForm::begin(
                [
                    'action' => 'add-contact-person?id=' . $id,
        ]);
?>
<div class="row">
    <div class="col-lg-6">
        <?=
        $form->field($model, 'title', [
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
        ])->widget(Select2::classname(), [
            'data' => [
                'Mr.' => 'Mr',
                'Mrs.' => 'Mrs',
                'Miss.' => 'Miss',
                'Ms.' => 'Ms',
                'Dr.' => 'Dr',
                'Prof.' => 'Prof'
            ],
            'options' => ['placeholder' => 'Select title', 'id' => 'title',
                'style' => "font-size:10px;"
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        <?=
        $form->field($model, 'formal_title'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Formal title'])
        ?>
        <?=
        $form->field($model, 'first_name'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'First name'])
        ?>
        <?=
        $form->field($model, 'other_names', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->textInput(['maxlength' => true,'placeholder' => 'Other names'])
        ?>
        <?=
                $form->field($model, 'last_name',
                        [
                            'enableAjaxValidation' => true,
                            'labelOptions' => [
                                'class' => 'is-required',
                                'style' => "font-weight:normal;",
                            ],
                        ]
                )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Surname'])
                ->label("Surname")
        ?>
        <?=
                $form->field($model, 'department',
                        [
                            'enableAjaxValidation' => true,
                            'labelOptions' => [
                                'class' => 'is-required',
                                'style' => "font-weight:normal;",
                            ],
                        ]
                )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Department'])
                ->label("Department")
        ?>

        <?=
        $form->field($model, 'email', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
            ],
        ])->textInput(['maxlength' => true,'placeholder' => 'Email address'])
        ?>





    </div>
    <div class="col-lg-6">
        <?php
        echo "<label style='font-weight:normal;margin-bottom:10px;' for='phone_id'>Mobile phone number<span class='text-danger'> *</span></label>";
        echo $form->field($model, 'mobile', [
            'labelOptions' => [
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
        <?php
        echo "<label style='font-weight:normal;margin-bottom:10px;' for='phone_whatsapp'>Whatsapp mobile phone number</label>";
        echo $form->field($model, 'whatsapp_number', [
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(PhoneInput::className(), [
            'options' => ['style' => 'width:275px;'],
            'jsOptions' => [
                'allowExtensions' => true,
                'preferredCountries' => ['ZM'],
            ]
                ], ['maxlength' => true, 'id' => "phone_whatsapp"])->label(false);
        ?> 
        <?=
        $form->field($model, 'telephone'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Telephone number'])
        ?>
        <?=
        $form->field($model, 'fax'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
               'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Fax number'])
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
    </div>

    <div class="col-lg-12">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-md font-weight-bold font-size:18px;']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

