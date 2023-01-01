
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\LoginForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Password Reset';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        &nbsp;
    </div>
    <div class="col-lg-5">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'reset-password-form',
        ]);
        ?>
        <div class="form-group">
            <?=
            $form->field($model, 'password', [
                'addon' => ['prepend' => ['content' => ' <span class="fas fa-lock"></span>']]
            ])->passwordInput(['class' => 'form-control ', 'autocorrect' => 'off', 'autocapitalize' => 'none',
                'autofocus' => false, 'placeholder' => 'Password',])->label(false);
            ?>
        </div>
        <div class="form-group">
            <?=
            $form->field($model, 'confirm_password', [
                'addon' => ['prepend' => ['content' => ' <span class="fas fa-lock"></span>']]
            ])->passwordInput(['class' => 'form-control ', 'autocorrect' => 'off', 'autocapitalize' => 'none',
                'autofocus' => false, 'placeholder' => 'Confirm Password',])->label(false);
            ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Reset', ['class' => 'btn btn-sm ' . Yii::$app->params['btnClass'] . ' me-1 mb-1 d-block w-100 mt-3', 'name' => 'login-button']) ?>
        </div>
        <div class="form-group mt-2 mb-0 row">
            <div class="col-12 mt-2">
                <?= Html::a('Go to login', ['site/login'], ['class' => "text-primary"]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

     <div class="col-lg-7 text-muted mb-5">
        <h6>Password must meet below requirements</h6>
        <ol>
            <li class="text-muted falcon-card-color fs--1">Password should contain at least 10 characters</li>
            <li class="text-muted falcon-card-color fs--1">Password should contain at least one upper case character (A-Z)</li>
            <li class="text-muted falcon-card-color fs--1">Password should contain at least one numeric character (0-9)</li>
            <li class="text-muted falcon-card-color fs--1">Password must contain a special character(@!#$%^&* etc)</li>
        </ol>
    </div>
</div>


