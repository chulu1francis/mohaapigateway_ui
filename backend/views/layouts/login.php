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
            <div class="container" data-layout="container">
                <script>
                    var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                    if (isFluid) {
                        var container = document.querySelector('[data-layout]');
                        container.classList.remove('container');
                        container.classList.add('container-fluid');
                    }
                </script>
                <div class="row flex-center min-vh-100 py-6">
                    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">

                        <div class="card">
                            <div class="card-body p-5 p-sm-3">
                                <div class="row flex-between-center">
                                    <div class="col-lg-12 text-center">
                                        <img class="me-2" src="<?= Url::to('@web/img/COA.jpeg') ?>" alt="" height="100" width="100" />
                                    </div>
                                    <div class="col-lg-12 text-center">&nbsp;</div>
                                    <div class="col-lg-12 text-center fs--1">
                                        <h4><?= Yii::$app->params['siteName'] ?></h4>
                                    </div>
                                    <div class="col-lg-12 text-center fs--1">
                                        <h5>Staff login</h5>
                                    </div>
                                    <hr>
                                </div>

                                <?= $content ?>

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
