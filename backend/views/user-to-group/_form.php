<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use backend\models\User;
use backend\models\AauthGroups;

/** @var yii\web\View $this */
/** @var backend\models\AauthUserToGroup $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="aauth-user-to-group-form">

    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
    ]);
    ?>
    <div class="mb-3 col-lg-6">
        <?=
        $form->field($model, 'user', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-size:14px;font-weight:normal;margin-bottom:-10px;",
            ],
        ])->widget(Select2::classname(), [
            'data' => User::getActiveUsersWithNames(),
//            'options' => ['placeholder' => 'Select user', 'id' => 'user'],
//            'pluginOptions' => [
//                'allowClear' => true
//            ],
        ])->label("User");
        ?>
    </div>
    <div class="mb-3 col-lg-6">
        <?=
        $form->field($model, 'group', [
            'enableAjaxValidation' => true,
            'labelOptions' => [
                'class' => 'is-required',
                'style' => "font-size:14px;font-weight:normal;margin-bottom:-10px;",
            ],
        ])->widget(Select2::classname(), [
            'data' => AauthGroups::getGroups(),
            'options' => ['placeholder' => 'Select user group', ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])->label("User group");
        ?>
    </div>
    <div class="mb-3 col-lg-6">
        <?= Html::submitButton('Save', ['class' => 'btn ' . Yii::$app->params['btnClass'] . ' btn-sm font-weight-bold font-size:18px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
