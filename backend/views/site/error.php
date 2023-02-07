<?php
/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */

/** @var Exception $exception */
use yii\helpers\Url;

$this->title = $name;
$this->title = "Error";
$this->params['breadcrumbs'][] = $this->title;
$arr = explode("(", $name);
$error_code = str_replace(")", "", str_replace("#", "", $arr[1]));
if (!Yii::$app->user->isGuest) {
    $action = '@web/home/index';
    $text = "Return to Dashboard";
    $main_text = "return to your dashboard";
    $icon = "fas fa-home";
} else {
    $action = '@web/site/login';
    $text = "Sign in";
    $main_text = "Sign in into your account";
    $icon = "fas fa-sign-in-alt";
}

if ($error_code == 404) {
    ?>
    <div class="row flex-center min-vh-2 py-2 text-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-4 p-sm-5">
                    <div class="fw-black lh-1 text-300 fs-error"><?= $error_code ?></div>
                    <p class="lead mt-4 text-800 font-sans-serif fw-semi-bold w-md-75 w-xl-100 mx-auto">
                        Oops! Page not found.
                    </p>
                    <hr />
                    <p>
                        We could not find the page you were looking for. Meanwhile, you may <?= $main_text ?>!
                    </p>
                    <a class="btn <?=Yii::$app->params['btnClass']?> btn-sm mt-3" href="<?= Url::to($action) ?>">
                       
                        <?= $text ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="row flex-center min-vh-2 py-2 text-center">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xxl-5">
            <div class="card">
                <div class="card-body p-4 p-sm-5">
                    <div class="fw-black lh-1 text-300 fs-error"><?= $error_code ?></div>
                    <p class="lead mt-4 text-800 font-sans-serif fw-semi-bold w-md-75 w-xl-100 mx-auto">
                        Oops! An Internal Server Error Occured.
                    </p>
                    <hr />
                    <p>
                        We will work on fixing that right away. Meanwhile, you may <?= $main_text ?>!
                    </p>
                    <a class="btn <?=Yii::$app->params['btnClass']?> btn-sm mt-3" href="<?= Url::to($action) ?>">
                       
                        <?= $text ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
