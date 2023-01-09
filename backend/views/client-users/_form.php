<?php

use yii\helpers\Html;
use backend\models\Clients;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\form\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\ClientUsers $model */
/** @var yii\widgets\ActiveForm $form */
$form = ActiveForm::begin(
                [
        ]);
?>

<div class="row">
    <div class="col-lg-6">
        <?=
        $form->field($model, 'client', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
               // 'class' => 'text-dark is-required',
                'style' => "font-size:13px;font-weight:normal;",
            ],
        ])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Clients::find()->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Select client', 'id' => 'role',
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
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'First name'])
        ?>
        <?=
        $form->field($model, 'last_name'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Last name'])
        ?>
        <?=
        $form->field($model, 'other_names'
                , [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'style' => "font-weight:normal;",
            ],
                ]
        )->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Other names'])
        ?>
        <?=
                $form->field($model, 'email', [
                    'enableAjaxValidation' => true,
                    'labelOptions' => [
                        'class' => 'is-required',
                    ],
                ])->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Email address'])
                ->label('Email')
        ?>
    </div>
    <div class="col-lg-6">
        <ol>
            <li class="falcon-card-color">Fields marked with <span class='text-danger'> *</span> are required</li>
            <li class="falcon-card-color">Email is used for login</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <?= Html::submitButton('Save', ['class' => 'btn ' . Yii::$app->params['btnClass'] . ' btn-md font-weight-bold font-size:18px;']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>


