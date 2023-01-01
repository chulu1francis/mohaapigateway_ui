
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\LoginForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Password Reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-5">
    <div class="card card-primary card-outline">
        <!--<div class="card card-header">
            <h5 class="card-title m-0" ><?php //echo Html::encode($this->title); ?></h5>
        </div>-->
        <div class="card-body ">
             <p>Set new password below</p>
            <div class="tab-pane" id="timeline">
            <h5>Password must meet below requirements</h5>
            <ol>
                <li>Password should contain at least 10 characters</li>
                <li>Password should contain at least one upper case character</li>
                <li>Password should contain at least one numeric / digit character</li>
                <li>Password should contain at least one special character</li>
            </ol>
            
            <hr class="dotted" >
            <?php
            $form = ActiveForm::begin([
                        'id' => 'reset-password-form',
                            /* 'fieldConfig' => [
                              'options' => [
                              'tag' => false,
                              ],
                              ], */
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
                <?= Html::submitButton('Reset', ['class' => 'btn btn-block btn-purple btn-sm font-size-16', 'name' => 'login-button']) ?>
            </div>
            <div style="color:#999;margin:1em 0">
                <?= Html::a('Login', ['site/login']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

