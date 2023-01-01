<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \common\models\LoginForm $model */
use yii\captcha\Captcha;
use yii\bootstrap5\Html;
use kartik\form\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'type' => ActiveForm::TYPE_FLOATING
    ]);
    ?>
    <div class="mb-3">
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    </div>
    <div class="mb-3">
        <?= $form->field($model, 'password')->passwordInput() ?>
    </div>
    <div class="form-group">
        <?php if ($model->scenario === 'captchaRequired') { ?>
            <?=
            $form->field($model, 'verifyCode')->widget(Captcha::className(),
                    [
                        'imageOptions' => ['id' => 'captcha-image', 'style' => ''],
                        'template' => '<div class="row">'
                        . '<div class="col-sm-9 captcha_img">{image}</div>'
                        . '<div class="col-sm-3"><a class="rounded-2 flex-1 ms-2 fs--1" id="refresh-captcha" href="#">'
                        . '<span class="material-icons text-primary fs-5">autorenew</span>'
                        . '</a></div>'
                        . '</div>'
                        . '<span class="fs--1 text-danger">'
                        . 'Too many wrong attempts. Enter captcha code above'
                        . '</span>{input}',
                    ])->label(false);
            ?> 

        <?php } ?>
    </div>
    <div class="form-group col-auto float-right">
        <?= Html::a('Forgot Password?', ['site/request-password-reset'], ['class' => "fs--1 text-primary"]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Sign in', ['class' => 'btn ' . Yii::$app->params['btnClass'] . ' me-1 mb-1 d-block w-100 mt-3', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

