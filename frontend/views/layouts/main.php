<?php
/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use frontend\models\Organisations;

AppAsset::register($this);
$show = "";
$active = "";
$this->beginPage();
$session = Yii::$app->session;
?>
<!DOCTYPE html>
<html class="navbar-vertical-collapsed" lang="en-US" dir="ltr">
    <head>
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Yii::$app->params['siteName'] ?>  | <?= Html::encode($this->title) ?></title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= Url::to('@web/img/logo.png') ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= Url::to('@web/img/logo.png') ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= Url::to('@web/img/logo.png') ?>">
        <link rel="shortcut icon" type="image/x-icon" href="<?= Url::to('@web/img/logo.png') ?>">
        <meta name="theme-color" content="#ffffff">

        <?php
        $script = <<< JS
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
                
JS;
        $this->registerJs($script, \yii\web\View::POS_READY);
        $script1 = <<< JS
          var isFluid = JSON.parse(localStorage.getItem('isFluid'));
            if (isFluid) {
                var container = document.querySelector('[data-layout]');
                container.classList.remove('container');
                container.classList.add('container-fluid');
            }         
JS;
        $this->registerJs($script1, \yii\web\View::POS_READY);
        ?>

        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
        <?php $this->beginBody() ?>


        <main class="main" id="top">
            <div class="container-fluid" data-layout="container">
                <script>
                    var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                    if (isFluid) {
                        var container = document.querySelector('[data-layout]');
                        container.classList.remove('container');
                        container.classList.add('container-fluid');
                    }
                </script>

                <nav class="navbar navbar-light navbar-vertical navbar-expand-xl" style="display: none;">

                    <div class="d-flex align-items-center">
                        <div class="toggle-icon-wrapper">
                            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                        </div>
                        <a class="navbar-brand" target="" href="<?= Url::toRoute('home/index') ?>">
                            <div class="d-flex align-items-center py-3">
                                <img class="me-2" src="<?= Url::to('@web/img/logo.png') ?>" alt="" width="40" />
                                <span class="font-sans-serif text-secondary fs-2">
                                    <?= Yii::$app->params['siteName'] ?> 
                                </span>
                            </div>
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                        <div class="navbar-vertical-content scrollbar">
                            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                                <li class="nav-item">
                                    <?php
                                    if (Yii::$app->controller->id == "home" &&
                                            (
                                            Yii::$app->controller->action->id == "index" ||
                                            Yii::$app->controller->action->id == "update-registration-details" ||
                                            Yii::$app->controller->action->id == "add-registration-details" ||
                                            Yii::$app->controller->action->id == "add-contact-person" ||
                                            Yii::$app->controller->action->id == "update-contact-person" ||
                                            Yii::$app->controller->action->id == "update-profile")) {
                                        echo Html::a(' <div class="d-flex align-items-center">
                                            <span class="nav-link-icon">
                                                <span class="fas fa-home"></span>
                                            </span>
                                             </span></span>
                                            <span class="nav-link-text ps-1">Dashboard</span>
                                        </div>', ['home/index'], ["class" => "nav-link active"]);
                                    } else {
                                        echo Html::a(' <div class="d-flex align-items-center">
                                            <span class="nav-link-icon">
                                                <span class="fas fa-home"></span>
                                            </span>
                                            </span></span>
                                            <span class="nav-link-text ps-1">Dashboard</span>
                                        </div>', ['home/index'], ["class" => "nav-link"]);
                                    }
                                    ?>
                                </li>
                                <li class="nav-item">
                                    <?php
                                    if (Yii::$app->controller->id == "requests" && Yii::$app->controller->action->id == "index") {
                                        echo Html::a(' <div class="d-flex align-items-center">
                                            <span class="nav-link-icon">
                                                <span class="fas fa-tasks"></span>
                                            </span>
                                             </span></span>
                                            <span class="nav-link-text ps-1">Requests</span>
                                        </div>', ['requests/index'], ["class" => "nav-link active"]);
                                    } else {
                                        echo Html::a(' <div class="d-flex align-items-center">
                                            <span class="nav-link-icon">
                                                <span class="fas fa-tasks"></span>
                                            </span>
                                            </span></span>
                                            <span class="nav-link-text ps-1">Requests</span>
                                        </div>', ['requests/index'], ["class" => "nav-link"]);
                                    }
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-xl" style="display: none;">
                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                </nav>
                <div class="content">
                    <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand" style="display: none;">
                        <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                        <a class="navbar-brand"  href="<?= Url::toRoute('home/index') ?>">
                            <div class="d-flex align-items-center">

                                <img class="me-2" src="<?= Url::to('@web/img/logo.png') ?>" alt="" width="40" />
                                <span class="font-sans-serif text-secondary"><?= Yii::$app->params['siteName'] ?></span>
                            </div>
                        </a>

                        <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">

                            <li class="nav-item dropdown">
                                <a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="avatar avatar-xl">
<?php
$orgLogo = '@web/img/icon.png';
if (!empty($session->get('logo'))) {
    $orgLogo = '@web/uploads/' . $session->get('logo');
}
?>
                                        <?= Html::img($orgLogo, ['class' => 'rounded-circle']); ?>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                    <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                        <span class="dropdown-item fw-bold">
                                            Hello <?= Yii::$app->getUser()->identity->last_name ?> 
                                        </span>

                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            Logout
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </nav>

                    <script>
                        var navbarPosition = localStorage.getItem('navbarPosition');
                        var navbarVertical = document.querySelector('.navbar-vertical');
                        var navbarTopVertical = document.querySelector('.content .navbar-top');
                        var navbarTop = document.querySelector('[data-layout] .navbar-top');
                        var navbarTopCombo = document.querySelector('.content [data-navbar-top="combo"]');
                        if (navbarPosition === 'top') {
                            navbarTop.removeAttribute('style');
                            navbarTopVertical.remove(navbarTopVertical);
                            navbarVertical.remove(navbarVertical);
                            navbarTopCombo.remove(navbarTopCombo);
                        } else if (navbarPosition === 'combo') {
                            navbarVertical.removeAttribute('style');
                            navbarTopCombo.removeAttribute('style');
                            navbarTop.remove(navbarTop);
                            navbarTopVertical.remove(navbarTopVertical);
                        } else {
                            navbarVertical.removeAttribute('style');
                            navbarTopVertical.removeAttribute('style');
                            navbarTop.remove(navbarTop);
                            navbarTopCombo.remove(navbarTopCombo);
                        }
                    </script>

                    <div class="card bg-light my-3">
                        <div class="card-body p-1 fs--3" style="margin-left: 10px;font-size: 15px;">
<?=
yii\bootstrap5\Breadcrumbs::widget([
    'homeLink' => ['label' => 'Home',
        'url' => Yii::$app->getHomeUrl() . '/home/index'],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])
?>
                        </div>
                    </div>

<?= $content ?>

                    <!--                    <footer class="footer">
                                            <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                                                <div class="col-12 col-sm-auto text-center">
                                                    <p class="mb-0 text-600"><?php //Yii::$app->params['institution']    ?>  
                                                        <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> 
                                                        2022 &copy; <a target="_blank" href="<?php //Yii::$app->params['website']    ?>">
<?php //Yii::$app->params['institutionShortName']   ?></a></p>
                                                </div>
                                            </div>
                                        </footer>-->
                </div>

            </div>
        </main>

        <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg mt-6" role="document">
                <div class="modal-content border-0">
                    <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                            <h4 class="mb-1" id="staticBackdropLabel">Ready to end session?</h4>
                        </div>
                        <div class="p-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    Select "Logout" below if you are ready to end your current session.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">

                            <button type="button" class="btn btn-falcon-danger btn-sm" data-bs-dismiss="modal">
                                <span class="fas fa-times-circle me-1" data-fa-transform="shrink-3"></span> Cancel
                            </button>
<?=
Html::a('<span class="fas fa-power-off me-1" data-fa-transform="shrink-3"></span> Logout', ['site/logout'], ['data' => ['method' => 'POST'], 'id' => 'logout',
    'class' => 'btn ' . Yii::$app->params['btnClass'] . ' btn-sm'])
?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

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
<?php
$this->endPage();

