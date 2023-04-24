<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en-US" dir="ltr">
    <head>
        <?= Html::csrfMetaTags() ?>
        <title><?= Yii::$app->params['siteName'] ?> | <?= Html::encode($this->title) ?></title>
        <!-- Basic -->
        <meta charset="UTF-8">

        <meta name="keywords" content="<?= Yii::$app->params['siteName'] ?>" />
        <meta name="description" content="<?= Yii::$app->params['siteName'] ?>">
        <meta name="author" content="okler.net">
        <meta name="theme-color" content="#ffffff">
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="apple-touch-icon" sizes="180x180" href="<?= Url::to('@web/img/logo.png') ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= Url::to('@web/img/logo.png') ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= Url::to('@web/img/logo.png') ?>">
        <link rel="shortcut icon" type="image/x-icon" href="<?= Url::to('@web/img/logo.png') ?>">
        <script>
            var isRTL = JSON.parse(localStorage.getItem('isRTL'));
            if (isRTL) {
                var linkDefault = document.getElementById('style-default');
                var userLinkDefault = document.getElementById('user-style-default');
                linkDefault.setAttribute('disabled', true);
                userLinkDefault.setAttribute('disabled', true);
                document.querySelector('html').setAttribute('dir', 'rtl');
            } else {
                var linkRTL = document.getElementById('style-rtl');
                var userLinkRTL = document.getElementById('user-style-rtl');
                linkRTL.setAttribute('disabled', true);
                userLinkRTL.setAttribute('disabled', true);
            }
        </script>
        <?php $this->head() ?>

    </head>
    <body>

        <?php $this->beginBody() ?>
        <!-- ===============================================-->
        <!--    Main Content-->
        <!-- ===============================================-->
        <main class="main" id="top">
            <div class="container-fluid">
                <div class="row min-vh-100 flex-center g-0">
                    <div class="col-lg-8 col-xxl-5 py-3 position-relative">
                        <div class="card overflow-hidden z-index-1">
                            <div class="card-body p-0">
                                <div class="row g-0 h-100">
                                    <div class="col-md-5 text-center bg-success">
                                        <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                            <div class="z-index-1 position-relative">
                                                <span class="link-light mb-4 font-sans-serif fs-2 d-inline-block fw-bolder">
                                                    <?= Yii::$app->params['siteName'] ?>
                                                </span>
                                                <p class="opacity-75 text-white">
                                                    The DNRPC INRIS API manager gives you access to the INRIS platform where you can query a citizens identity data 
                                                    using a citizens NRC number.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-3 mb-4 mt-md-4 mb-md-5 light">
<!--                                            <p class="text-white">Not registered yet?<br>
                                                <a class="text-decoration-underline link-light" href="<?= Url::to('register') ?>">
                                                    Click here to register an account 
                                                </a>
                                            </p>-->
                                            <p class="mb-0 mt-4 mt-md-5 fs--1 fw-semi-bold text-white opacity-75">
                                                Read our <a class="text-decoration-underline text-white" href="#!">terms</a> and 
                                                <a class="text-decoration-underline text-white" href="">conditions </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-7 d-flex flex-center">
                                        <div class="p-4 p-md-5 flex-grow-1">
                                            <div class="row flex-between-center">
                                                <div class="col-lg-12 text-center pb-2">
                                                    <img class="me-2" src="<?= Url::to('@web/img/COA.jpeg') ?>" alt="" height="120" width="120" />
                                                </div>
                                                <div class=" text-center">
                                                    <h3>DNRPC INRIS API Manager</h3>
                                                </div>
                                                <div class=" text-center">
                                                    <h4>Client Login</h4>
                                                </div>
                                            </div>
                                            <?= $content ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!--    End of Main Content-->
        <!-- ===============================================-->
        <?php
        if (Yii::$app->session->getFlash('success')) {
            echo kartik\widgets\Growl::widget([
                'type' => kartik\widgets\Growl::TYPE_SUCCESS,
                'title' => 'Success!',
                'icon' => 'fas fa-check-circle fa-2x',
                'body' => Yii::$app->session->getFlash('success'),
                'progressBarOptions' => ['class' => 'progress-bar-success'],
                'showSeparator' => true,
                'delay' => 50,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'bottom',
                        'align' => 'center',
                    ]
                ]
            ]);
        }

        if (Yii::$app->session->getFlash('error')) {
            echo kartik\widgets\Growl::widget([
                'type' => kartik\widgets\Growl::TYPE_DANGER,
                'title' => 'Error!',
                'icon' => 'fas fa-times-circle  fa-2x',
                'body' => Yii::$app->session->getFlash('error'),
                'showSeparator' => true,
                'delay' => 50,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'bottom',
                        'align' => 'center',
                    ]
                ]
            ]);
        }

        if (Yii::$app->session->getFlash('warning')) {
            echo kartik\widgets\Growl::widget([
                'type' => kartik\widgets\Growl::TYPE_WARNING,
                'title' => 'Warning!',
                'icon' => 'fas fa-exclamation-circle  fa-2x',
                'body' => Yii::$app->session->getFlash('warning'),
                'showSeparator' => true,
                'delay' => 50,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'bottom',
                        'align' => 'center',
                    ]
                ]
            ]);
        }
        $this->endBody();
        ?>

    </body>
</html>
<?php $this->endPage() ?>
