<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\AauthGroups;
use borales\extensions\phoneInput\PhoneInput;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\FileInput;

/** @var yii\web\View $this */
/** @var backend\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>



<?php
$form = ActiveForm::begin([
                // 'type' => ActiveForm::TYPE_FLOATING,
        ]);
?>
<div class="row">
    <div class="col-lg-4 mb3">
        <?=
        $form->field($model, 'group', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'text-dark is-required',
                'style' => "font-size:13px;font-weight:normal;",
            ],
        ])->widget(Select2::classname(), [
            'data' => yii\helpers\ArrayHelper::map(AauthGroups::find()->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Select user group', 'id' => 'role',
                'style' => "font-size:10px;"
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        <?=
        $form->field($model, 'title', [
            'labelOptions' => [
                'class' => 'text-dark is-required',
                'style' => "font-size:13px;font-weight:normal;",
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
        $form->field($model, 'first_name'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'text-dark is-required',
                'style' => "font-size:13px;font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'First name'])
        ?>
        <?=
        $form->field($model, 'other_name', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'text-dark',
                'style' => "font-size:13px;font-weight:normal;",
            ],
        ])->textInput(['maxlength' => true])
        ?>
        
    </div>
    <div class="col-lg-4 mb3">
        <?=
                $form->field($model, 'last_name',
                        [
                            'enableAjaxValidation' => true,
                            'labelOptions' => [
                                'class' => 'text-dark is-required',
                                'style' => "font-size:13px;font-weight:normal;",
                            ],
                        ]
                )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Surname'])
                ->label("Surname")
        ?>
        <?=
        $form->field($model, 'man_number'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'text-dark is-required',
                'style' => "font-size:13px;font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Man number'])
        ?>
        <?=
        $form->field($model, 'email', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'text-dark is-required',
            ],
        ])->textInput(['maxlength' => true])
        ?>
        <?php
        echo "<label class='text-dark' style='font-size:13px;font-weight:normal;margin-bottom:10px;' for='phone1'>Mobile phone number</label>";
        echo $form->field($model, 'phone', [
            'labelOptions' => [
                'class' => 'text-dark',
                'style' => "font-size:13px;font-weight:normal;",
            ],
        ])->widget(PhoneInput::className(), [
            'options' => ['style' => 'width:275px;'],
            'jsOptions' => [
                'allowExtensions' => true,
                'preferredCountries' => ['ZM'],
            ]
                ], ['maxlength' => true, 'id' => "phone_id"])->label(false);
        ?> 
        
    </div>
    <div class="col-lg-4 mb3">
        <?php
        echo $form->field($model, 'image', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'text-dark',
                'style' => "font-size:13px;font-weight:normal;",
            ],
        ])->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
                'showCancel' => true,
                'browseClass' => 'btn btn-falcon-success',
                'cancelClass' => 'btn btn-falcon-danger',
                'browseIcon' => '<i class="bi bi-camera"></i>',
                'cancelIcon' => '<i class="bi bi-x-circle"></i>',
                'maxFileSize' => 10240,
            ]
        ])->label("Profile picture")
        ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save user', ['class' => 'btn ' . Yii::$app->params['btnClass'] . ' btn-sm font-weight-bold font-size:18px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
