<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use backend\models\Regions;
use kartik\date\DatePicker;

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
                    'action' => 'add-registration-details?id=' . $id,
                    'enableAjaxValidation'=>true,
        ]);
?>
<div class="row">
    <div class="col-lg-6">
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

        <?=
        $form->field($model, 'number'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Registration number'])
        ?>
        <?=
        $form->field($model, 'registration_date', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter registration date', "id" => "reg_date",],
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd',
            ]
        ]);
        ?>  
        <?=
        $form->field($model, 'registration_expiry_date', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter registration expiry date', "id" => "expiry_date",],
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>  



    </div>
    <div class="col-lg-6">
        <h4>Instructions</h4>
        <ol>
            <li class="fs--1"> You cannot enter an expiry date that is before the registration date</li>
            <li class="fs--1"> Fields marked with <span class="text-danger"> *</span> are required</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-md font-weight-bold font-size:18px;']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

