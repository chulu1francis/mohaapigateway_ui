<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\widgets\FileInput;
use backend\models\Currencies;
use kartik\number\NumberControl;

/** @var yii\web\View $this */
/** @var backend\models\AccreditationApplications $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php
$form = ActiveForm::begin([
           // 'id' => 'create-consultative',
            'options' => ['enctype' => 'multipart/form-data']
        ]);
?>
<div class="row">
    <div class="col-lg-6">
        <?=
        $form->field($model, 'letter', [
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/pdf',],
            'pluginOptions' => [
                'showPreview' => false,
                'showCancel' => false,
                'showUpload' => false,
                'browseLabel' => 'Browse files',
                'removeLabel' => '',
                'mainClass' => 'input-group-lg',
                'maxFileSize' => 20480,
            ]
        ])->label("Application letter")
        ?>
        <?=
        $form->field($model, 'registration_or_acknowledgement_certificate', [
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/pdf',],
            'pluginOptions' => [
                'showPreview' => false,
                'showCancel' => false,
                'showUpload' => false,
                'browseLabel' => 'Browse files',
                'removeLabel' => '',
                'mainClass' => 'input-group-lg',
                'maxFileSize' => 20480,
            ]
        ])->label("Registration or Acknowledgement Certificate")
        ?>
        <?=
        $form->field($model, 'certified_articles_of_association', [
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/pdf',],
            'pluginOptions' => [
                'showPreview' => false,
                'showCancel' => false,
                'showUpload' => false,
                'browseLabel' => 'Browse files',
                'removeLabel' => '',
                'mainClass' => 'input-group-lg',
                'maxFileSize' => 20480,
            ]
        ])->label("Certified Articles of Association")
        ?>
        <?=
        $form->field($model, 'bylaws', [
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/pdf',],
            'pluginOptions' => [
                'showPreview' => false,
                'showCancel' => false,
                'showUpload' => false,
                'browseLabel' => 'Browse files',
                'removeLabel' => '',
                'mainClass' => 'input-group-lg',
                'maxFileSize' => 20480,
            ]
        ])->label("By laws")
        ?>
        <?=
        $form->field($model, 'currency', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(Select2::classname(), [
            'data' => Currencies::getCurrencies(),
            'options' => ['placeholder' => 'Select currency', 'id' => 'currency_id'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label("Currency");
        ?>

        <?=
        $form->field($model, 'income', [
            'enableAjaxValidation' => true
        ])->widget(NumberControl::classname(), [
            'maskedInputOptions' => [
                // 'prefix' => '$ ',
                'suffix' => '',
                'allowMinus' => false,
                'min' => 1,
                'max' => 1000000000
            ],
        ]);
        ?>
        <?=
        $form->field($model, 'expenditure', [
            'enableAjaxValidation' => true
        ])->widget(NumberControl::classname(), [
            'maskedInputOptions' => [
                // 'prefix' => '$ ',
                'suffix' => '',
                'allowMinus' => false,
                'min' => 1,
                'max' => 1000000000
            ],
        ]);
        ?>
    </div>
    <div class="col-lg-6">
        <?=
        $form->field($model, 'statutes_or_constitution_detailing_the_mandate', [
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/pdf',],
            'pluginOptions' => [
                'showPreview' => false,
                'showCancel' => false,
                'showUpload' => false,
                'browseLabel' => 'Browse files',
                'removeLabel' => '',
                'mainClass' => 'input-group-lg',
                'maxFileSize' => 20480,
            ]
        ])->label("Statutes or Constitution of mandate")
        ?>
        <?=
        $form->field($model, 'scope_and_governing_structure_or_organisational_profile', [
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/pdf',],
            'pluginOptions' => [
                'showPreview' => false,
                'showCancel' => false,
                'showUpload' => false,
                'browseLabel' => 'Browse files',
                'removeLabel' => '',
                'mainClass' => 'input-group-lg',
                'maxFileSize' => 20480,
            ]
        ])->label("Scope and Governing Structure or Organisational Profile")
        ?>
        <?=
        $form->field($model, 'annual_income_and_expenditure_statement', [
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/pdf',],
            'pluginOptions' => [
                'showPreview' => false,
                'showCancel' => false,
                'showUpload' => false,
                'browseLabel' => 'Browse files',
                'removeLabel' => '',
                'mainClass' => 'input-group-lg',
                'maxFileSize' => 20480,
            ]
        ])->label("Annual Income And Expenditure Statement")
        ?>
        <?=
        $form->field($model, 'names_of_all_donors_and_other_funding_sources_last_two_years', [
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/pdf',],
            'pluginOptions' => [
                'showPreview' => false,
                'showCancel' => false,
                'showUpload' => false,
                'browseLabel' => 'Browse files',
                'removeLabel' => '',
                'mainClass' => 'input-group-lg',
                'maxFileSize' => 20480,
            ]
        ])->label("Names of all Donors and other Funding Sources last two years")
        ?>
        <?=
        $form->field($model, 'evidence_of_competency_in_thematic_areas', [
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/pdf',],
            'pluginOptions' => [
                'showPreview' => false,
                'showCancel' => false,
                'showUpload' => false,
                'browseLabel' => 'Browse files',
                'removeLabel' => '',
                'mainClass' => 'input-group-lg',
                'maxFileSize' => 20480,
            ]
        ])->label("Evidence of Competency in Thematic Areas")
        ?>
        <?=
        $form->field($model, 'other_relevant_documents', [
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
        ])->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/pdf',],
            'pluginOptions' => [
                'showPreview' => false,
                'showCancel' => false,
                'showUpload' => false,
                'browseLabel' => 'Browse files',
                'removeLabel' => '',
                'mainClass' => 'input-group-lg',
                'maxFileSize' => 20480,
            ]
        ])->label("Other Relevant Documents")
        ?>

        <p style="margin-top: 0;">
            <a class="text-primary fs-1" href="<?= Yii::$app->params['AUDataPolicyLink'] ?>" target="_blank" >
                Read AU data policy
            </a>
        </p>

        <?php
        echo $form->field($model, 'compliance_with_au_data_policy', [
                    'labelOptions' => [
                        'style' => "font-size:16px;font-weight:normal;cursor:pointer;",
                    ],
                ])->checkbox(['custom' => true, 'style' => "width:20px;height:20px;"])
                ->label("<span>&nbsp; Compliant with AU data policy</span>");
        ?>
    </div>
    <div class="col-lg-12">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-md font-weight-bold font-size:18px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>
