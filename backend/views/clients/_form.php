<?php

use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use borales\extensions\phoneInput\PhoneInput;

/** @var yii\web\View $this */
/** @var backend\models\Clients $model */
/** @var yii\widgets\ActiveForm $form */
if (empty($model->can_pay)) {
    $model->can_pay = "Yes";
}
$form = ActiveForm::begin(
                [
        ]);
?>

<div class="row">
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
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Client name'])
        ?>
        <?=
        $form->field($model, 'contact_person_first_name'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Contact person first name'])
        ?>
        <?=
        $form->field($model, 'contact_person_last_name'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Contact person last name'])
        ?>
        <?=
                $form->field($model, 'email', [
                    'enableAjaxValidation' => true,
                    'labelOptions' => [
                        'class' => 'is-required',
                    ],
                ])->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Contact person email address'])
                ->label('Contact person email')
        ?>
    </div>
    <div class="col-lg-6">
        <?php
        echo "<label style='font-weight:normal;margin-bottom:10px;' for='phone_whatsapp'>Contact person mobile phone number</label>";
        echo $form->field($model, 'phone', [
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
        $form->field($model, 'can_pay')->radioList(
                [
                    "Yes" => "Yes",
                    "No" => "No",
                ],
                [
                    'options' => ['style' => "curson:pointer",],
                    'custom' => true,
                    'id' => 'custom-radio-list',
                    'inline' => true,
                    'labelSpan' => '10px'
                ]
        )->label("Can client pay to access services");
        ?>
        <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Client address']) ?>
    </div>
    <div class="col-lg-12">
        <?= Html::submitButton('Save', ['class' => 'btn ' . Yii::$app->params['btnClass'] . ' btn-md font-weight-bold font-size:18px;']) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>
