<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use backend\models\AauthPerm;

/* @var $this yii\web\View */
/* @var $model common\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>



<?php
$form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_FLOATING,
        ]);
?>
<div class="mb-3 col-lg-6">

    <?=
    $form->field($model, 'name', [
        'enableAjaxValidation' => true,
        'labelOptions' => [
            'class' => 'text-dark is-required',
            'style' => "font-size:14px;font-weight:normal;",
        ],
    ])->textInput(['maxlength' => true])->label("Group name");
    ?>

</div>
<div class="mb-3">
    <label class="form-label is-required text-dark">Permissions</label>
    <div class='form-check'>
        <?php
//        $VIEW = AauthPerm::find()->where(['group' => "VIEW"])->asArray()->all();
//        $MANAGE = AauthPerm::find()->where(['group' => "MANAGE"])->asArray()->all();
//        $array = array_merge([
//            "MANAGE" => $MANAGE,
//            "VIEW" => $VIEW
//        ]);
////        var_dump($array);
////
//        foreach ($array as $key => $value) {
//            echo '<p>' . $key . '</p>';
//            echo $form->field($model, 'permissions')->label(false)
//                    ->checkboxList(yii\helpers\ArrayHelper::map($value, 'id', 'name'),
//                            [
//                                'inline' => true,
//                                'custom' => true,
//                                'separator' => false,
////                                'item' => function ($index, $label, $name, $checked, $value) {
////                                    $checked = $checked ? 'checked' : '';
////                                    return "<label class='form-check-label' style='font-size:15px;cursor: pointer;' >&nbsp;&nbsp;{$label} </label> "
////                                    . "<input class='form-check-input' type='checkbox' {$checked} name='{$name}' value='{$value}'>";
////                                },
//                                'template' => '<div class="row"><div class="col-md-3">{label}&nbsp;{input}</div></div>'
//            ]);
//        }
        ?>
        <?php
//        $count=0;
//        foreach ($array as $key => $permissions) {
//            echo '<p><h5>' . $key . '</h5></p>';
        echo $form->field($model, 'permissions', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'text-dark is-required',
                'style' => "font-size:14px;font-weight:normal;",
            ],
        ])->checkboxList(ArrayHelper::map(AauthPerm::getPermissions(), 'id', 'name'), [
            'custom' => true,
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = $checked ? 'checked' : '';
                return "<label class='form-check-label col-md-3' style='font-size:15px;cursor: pointer;' > "
                . "<input class='form-check-input' type='checkbox' {$checked} name='{$name}' value='{$value}'>&nbsp;&nbsp;{$label} </label>";
            },
            'separator' => false,
            'required' => true,
        ])->label(false);
//                $count++;
//        }
        ?>
    </div>
</div>
<div class="mb-3">
    <?= Html::submitButton('Save', ['class' => 'btn ' . Yii::$app->params['btnClass'] . ' btn-sm font-weight-bold font-size:18px;']) ?>
</div>

<?php ActiveForm::end(); ?>

