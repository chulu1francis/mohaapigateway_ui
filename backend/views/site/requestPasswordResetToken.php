

<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\LoginForm */

use yii\helpers\Html;
//use yii\bootstrap4\ActiveForm;
//use kartik\form\ActiveField;
use kartik\form\ActiveForm;

$this->title = 'Password reset request';
$this->params['breadcrumbs'][] = $this->title;
?>



<?php
$form = ActiveForm::begin([
            'class' => "form-horizontal mt-4"
        ]);
?>

<p class="text-secondary fs--1 text-center">
    Enter your registered email.<br> A link to reset your password will be sent there.
</p>
<div class="form-group mb-3">
    <?=
    $form->field($model, 'email', ['enableAjaxValidation' => true,
        'addon' => ['prepend' => ['content' => ' <span class="fas fa-envelope"></span>']]
    ])->textInput(['autofocus' => false, 'placeholder' => 'Enter registered email',])->label(false);
    ?>
</div>

<div class="form-group text-center">
    <?= Html::submitButton('Request', ['class' => 'btn btn-sm ' . Yii::$app->params['btnClass'] . ' me-1 mb-1 d-block w-100 mt-3', 'name' => 'login-button']) ?>
</div>

<?php ActiveForm::end(); ?>
<div class="form-group mt-2 mb-0 row">
    <div class="col-12 mt-2">
        <?= Html::a('Remembered password?', ['site/login'],['class'=>'fs--1 text-primary']) ?>
    </div>
</div>



