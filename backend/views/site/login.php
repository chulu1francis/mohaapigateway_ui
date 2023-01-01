<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\captcha\Captcha;
use yii\bootstrap5\Html;
use kartik\form\ActiveForm;

$this->title = 'Staff Login';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php
$form = ActiveForm::begin([
            'id' => 'login-form',
            'type' => ActiveForm::TYPE_FLOATING
        ]);
?>
<div class="mb-3">

    <?=
    $form->field($model, 'username',
            [
                'labelOptions' => [
                    'class' => 'form-label',
                    'style' => "font-size:13px;font-weight:normal;",
                ],

            ])->textInput([
        'class' => 'form-control',
        'maxlength' => true,
        'autocorrect' => 'off',
        'autocapitalize' => 'none',
        'autofocus' => false,
        'placeholder' => 'Staff email address',])->label('Email');
    ?>
</div>
<?=
$form->field($model, 'password', [
    'labelOptions' => [
        'class' => 'form-label',
        'style' => "font-size:13px;font-weight:normal;",
    ],
        //'addon' => ['prepend' => ['content' => ' <span class="fas fa-lock"></span>']]
])->passwordInput([
    'class' => 'form-control',
    'maxlength' => true,
    'id' => 'userpassword',
    'autocorrect' => 'off',
    'autocapitalize' => 'none',
    'autofocus' => false,
    'placeholder' => 'Password',])->label("Password");
?>


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
<div class="form-group col-auto">
    <?= Html::a('Forgot Password?', ['site/request-password-reset'], ['class' => "fs--1 text-primary"]) ?>
</div>

<div class="form-group">
    <?= Html::submitButton('Sign in', ['class' => 'btn btn-sm ' . Yii::$app->params['btnClass'] . ' me-1 mb-1 d-block w-100 mt-3', 'name' => 'login-button']) ?>
</div>

<?php ActiveForm::end(); ?>

