<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use backend\models\User;

AppAsset::register($this);
$show = "";
$active = "";
$this->beginPage();
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
                                    if (Yii::$app->controller->id == "home" && Yii::$app->controller->action->id == "index") {
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
                                    if (User::isUserAllowedTo("Manage users") || User::isUserAllowedTo("View users") ||
                                            User::isUserAllowedTo("Manage groups") || User::isUserAllowedTo("View groups")) {
                                        ?>

                                        <!-- parent pages-->
                                        <?php
                                        if (Yii::$app->controller->id == "user" ||
                                                Yii::$app->controller->id == "groups" ||
                                                Yii::$app->controller->id == "user-permissions" ||
                                                Yii::$app->controller->id == "user-to-group"
                                        ) {
                                            $show = "show";
                                            $active = "active";
                                        }
                                        ?>
                                        <a class="nav-link <?= $active ?> dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="dashboard">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-icon">
                                                    <span class="fas fa-users">
                                                    </span></span>
                                                <span class="nav-link-text ps-1">User Management</span>
                                            </div>
                                        </a>

                                        <ul class="nav collapse <?= $show ?>" id="dashboard">
                                            <?php
                                            if (User::isUserAllowedTo("Manage groups") || User::isUserAllowedTo("View groups")) {
                                                if (Yii::$app->controller->id == "groups" &&
                                                        (Yii::$app->controller->action->id == "index" ||
                                                        Yii::$app->controller->action->id == "view" ||
                                                        Yii::$app->controller->action->id == "create" ||
                                                        Yii::$app->controller->action->id == "update")) {
                                                    echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">Groups</span></div>', ['groups/index'], ["class" => 'nav-link active']) . '</li>';
                                                } else {
                                                    echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">Groups</span></div>', ['groups/index'], ["class" => 'nav-link']) . '</li>';
                                                }
                                            }

                                            if (User::isUserAllowedTo("Manage user to group")) {
                                                if (Yii::$app->controller->id == "user-to-group" &&
                                                        (Yii::$app->controller->action->id == "index")) {
                                                    echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">User to group</span></div>', ['user-to-group/index'], ["class" => 'nav-link active']) . '</li>';
                                                } else {
                                                    echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">User to group</span></div>', ['user-to-group/index'], ["class" => 'nav-link']) . '</li>';
                                                }
                                            }
//                                           

                                            if (User::isUserAllowedTo("Manage users") || User::isUserAllowedTo("View Users")) {
                                                if (Yii::$app->controller->id == "user" &&
                                                        (Yii::$app->controller->action->id == "index" ||
                                                        Yii::$app->controller->action->id == "view" ||
                                                        Yii::$app->controller->action->id == "create" ||
                                                        Yii::$app->controller->action->id == "update")) {
                                                    echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">Users</span></div>', ['user/index'], ["class" => 'nav-link active']) . '</li>';
                                                } else {
                                                    echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">Users</span></div>', ['user/index'], ["class" => 'nav-link']) . '</li>';
                                                }
                                            }
                                            ?>

                                        </ul>
                                    <?php } ?>
                                </li>

                                <li class="nav-item">
                                    <?php
                                    if (User::isUserAllowedTo("View applications") ||
                                             User::isUserAllowedTo("Approve accreditations applications")||
                                             User::isUserAllowedTo("Review national accreditations")||
                                            User::isUserAllowedTo("Review consultative accreditations")) {
                                        $show = "";
                                        $active = "";
                                        ?>
                                        <?php
                                        if (Yii::$app->controller->id == "accreditation-applications"
                                        ) {
                                            $show = "show";
                                            $active = "active";
                                        }
                                        ?>
                                        <a class="nav-link <?= $active ?> dropdown-indicator" href="#accreditations" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="accreditations">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-icon">
                                                    <span class="fas fa-folder-open">
                                                    </span></span>
                                                <span class="nav-link-text ps-1">Accreditations</span>
                                            </div>
                                        </a>

                                        <ul class="nav collapse <?= $show ?>" id="accreditations">
                                            <?php
                                            if (Yii::$app->controller->id == "accreditation-applications" &&
                                                    (Yii::$app->controller->action->id == "consultative" ||
                                                    Yii::$app->controller->action->id == "view" ||
                                                    Yii::$app->controller->action->id == "review" ||
                                                    Yii::$app->controller->action->id == "approve")) {
                                                echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">Consultative status</span></div>', ['accreditation-applications/consultative'], ["class" => 'nav-link active']) . '</li>';
                                            } else {
                                                echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">Consultative status</span></div>', ['accreditation-applications/consultative'], ["class" => 'nav-link']) . '</li>';
                                            }


                                            if (Yii::$app->controller->id == "accreditation-applications" &&
                                                    (Yii::$app->controller->action->id == "national" ||
                                                    Yii::$app->controller->action->id == "view-national" ||
                                                    Yii::$app->controller->action->id == "approve-national" ||
                                                    Yii::$app->controller->action->id == "review-national")) {
                                                echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">National status</span></div>', ['accreditation-applications/national'], ["class" => 'nav-link active']) . '</li>';
                                            } else {
                                                echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">National status</span></div>', ['accreditation-applications/national'], ["class" => 'nav-link']) . '</li>';
                                            }

                                            if (Yii::$app->controller->id == "observer-applications" &&
                                                    (Yii::$app->controller->action->id == "index" ||
                                                    Yii::$app->controller->action->id == "view" ||
                                                    Yii::$app->controller->action->id == "create" ||
                                                    Yii::$app->controller->action->id == "update")) {
                                                echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">Observer status</span></div>', ['user/index'], ["class" => 'nav-link active']) . '</li>';
                                            } else {
                                                echo '<li class="nav-item">' . Html::a('<div class="d-flex align-items-center"><span class="nav-link-text ps-1">Observer status</span></div>', ['user/index'], ["class" => 'nav-link']) . '</li>';
                                            }
                                            ?>

                                        </ul>
                                    <?php } ?>
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
                            <li class="nav-item">
                                <div class="theme-control-toggle fa-icon-wait px-2"><input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="theme" value="dark" /><label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to light theme"><span class="fas fa-sun fs-0"></span></label><label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to dark theme"><span class="fas fa-moon fs-0"></span></label></div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="avatar avatar-xl">
                                        <?= Html::img('@web/img/icon.png', ['class' => 'rounded-circle']); ?>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                    <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                        <span class="dropdown-item fw-bold">
                                            Hi! <?= Yii::$app->getUser()->identity->title ?> <?= Yii::$app->getUser()->identity->last_name ?>
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

                    <footer class="footer">
                        <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                            <div class="col-12 col-sm-auto text-center">
                                <p class="mb-0 text-600"><?= Yii::$app->params['institution'] ?>  
                                    <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> 
                                    2022 &copy; <a target="_blank" href="<?= Yii::$app->params['website'] ?>">
                                        <?= Yii::$app->params['institutionShortName'] ?></a></p>
                            </div>
                        </div>
                    </footer>
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

