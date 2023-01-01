<?php
/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
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
        <link rel="shortcut icon" type="image/x-icon" href="<?= Url::to('@web/img/AU_logo.png') ?>">
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
            <nav class="navbar navbar-standard navbar-expand-lg fixed-top navbar-dark" data-navbar-darken-on-scroll="data-navbar-darken-on-scroll">
                <div class="container">

                    <a class="navbar-brand" href="../index.html">
                        <div class="d-flex align-items-center py-0">
                            <img class="me-2" src="<?= Url::to('@web/img/logo.png') ?>" alt="" width="40" />
                            <span class="text-white dark__text-white">
                                <?= Yii::$app->params['siteName'] ?> Portal
                            </span>
                        </div>
                    </a>
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
                        <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">

                            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="documentations">Documentation</a>
                                <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="documentations">
                                    <div class="bg-white dark__bg-1000 rounded-3 py-2">
                                        <a class="dropdown-item link-600 fw-medium" href="../documentation/getting-started.html">
                                            Getting started</a>
                                        <a class="dropdown-item link-600 fw-medium" href="../documentation/customization/configuration.html">Configuration</a>
                                        <a class="dropdown-item link-600 fw-medium" href="../documentation/customization/styling.html">Styling<span class="badge rounded-pill ms-2 badge-soft-success">Updated</span></a>
                                        <a class="dropdown-item link-600 fw-medium" href="../documentation/customization/dark-mode.html">Dark mode</a>
                                        <a class="dropdown-item link-600 fw-medium" href="../documentation/customization/plugin.html">Plugin</a>
                                        <a class="dropdown-item link-600 fw-medium" href="../documentation/faq.html">Faq</a>
                                        <a class="dropdown-item link-600 fw-medium" href="../documentation/gulp.html">Gulp</a>
                                        <a class="dropdown-item link-600 fw-medium" href="../documentation/design-file.html">Design file</a>
                                        <a class="dropdown-item link-600 fw-medium" href="../changelog.html">Changelog</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item"><span class="nav-link">Are you an Organisation?</span></li>
                            <li class="nav-item"><a class="nav-link" href="<?= Url::to('site/login') ?>" >Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= Url::to('site/register') ?>">Register</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="row text-start justify-content-between align-items-center mb-2">
                                <div class="col-auto">
                                    <h5 id="modalLabel">Register</h5>
                                </div>
                                <div class="col-auto">
                                    <p class="fs--1 text-600 mb-0">Have an account? <a href="../pages/authentication/simple/login.html">Login</a></p>
                                </div>
                            </div>
                            <form>
                                <div class="mb-3">
                                    <input class="form-control" type="text" autocomplete="on" placeholder="Name" />
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="email" autocomplete="on" placeholder="Email address" />
                                </div>
                                <div class="row gx-2">
                                    <div class="mb-3 col-sm-6">
                                        <input class="form-control" type="password" autocomplete="on" placeholder="Password" />
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <input class="form-control" type="password" autocomplete="on" placeholder="Confirm Password" />
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="modal-register-checkbox" />
                                    <label class="form-label" for="modal-register-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button>
                                </div>
                            </form>
                            <div class="position-relative mt-4">
                                <hr class="bg-300" />
                                <div class="divider-content-center">or register with</div>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google</a></div>
                                <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="py-0 overflow-hidden light" id="banner">

                <div class="bg-holder overlay" style="background-image:url(<?= Url::to('@web/img/bg-1.jpg') ?>);background-position: center bottom;">
                </div>
                <!--/.bg-holder-->

                <div class="container">
                    <div class="row flex-center pt-8 pt-lg-10 pb-lg-9 pb-xl-0">
                        <div class="col-md-11 col-lg-8 col-xl-4 pb-7 pb-xl-9 text-center text-xl-start"><a class="btn btn-outline-danger mb-4 fs--1 border-2 rounded-pill" href="#!"><span class="me-2" role="img" aria-label="Gift">🎁</span>Become a pro</a>
                            <h1 class="text-white fw-light">Bring <span class="typed-text fw-bold" data-typed-text='["design","beauty","elegance","perfection"]'></span><br />to your webapp</h1>
                            <p class="lead text-white opacity-75">With the power of Falcon, you can now focus only on functionaries for your digital products, while leaving the UI design on us!</p><a class="btn btn-outline-light border-2 rounded-pill btn-lg mt-4 fs-0 py-2" href="#!">Start building with the falcon<span class="fas fa-play ms-2" data-fa-transform="shrink-6 down-1"></span></a>
                        </div>
                        <div class="col-xl-7 offset-xl-1 align-self-end mt-4 mt-xl-0"><a class="img-landing-banner rounded" href="../index.html"><img class="img-fluid" src="../assets/img/generic/dashboard-alt.jpg" alt="" /></a></div>
                    </div>
                </div>
                <!-- end of .container-->

            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->




            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="py-3 bg-light shadow-sm">

                <div class="container">
                    <div class="row flex-center">
                        <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="40" src="../assets/img/logos/b&amp;w/6.png" alt="" /></div>
                        <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="45" src="../assets/img/logos/b&amp;w/11.png" alt="" /></div>
                        <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="30" src="../assets/img/logos/b&amp;w/2.png" alt="" /></div>
                        <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="30" src="../assets/img/logos/b&amp;w/4.png" alt="" /></div>
                        <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="35" src="../assets/img/logos/b&amp;w/1.png" alt="" /></div>
                        <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="40" src="../assets/img/logos/b&amp;w/10.png" alt="" /></div>
                        <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="40" src="../assets/img/logos/b&amp;w/12.png" alt="" /></div>
                    </div>
                </div>
                <!-- end of .container-->

            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->




            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section>

                <div class="container">
                    <div class="row justify-content-center text-center">
                        <div class="col-lg-8 col-xl-7 col-xxl-6">
                            <h1 class="fs-2 fs-sm-4 fs-md-5">WebApp theme of the future</h1>
                            <p class="lead">Built on top of Bootstrap 5, super modular Falcon provides you gorgeous design &amp; streamlined UX for your WebApp.</p>
                        </div>
                    </div>
                    <div class="row flex-center mt-8">
                        <div class="col-md col-lg-5 col-xl-4 ps-lg-6"><img class="img-fluid px-6 px-md-0" src="<?= Url::to('@web/img/50.png') ?>" alt="" /></div>
                        <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0">
                            <h5 class="text-danger"><span class="far fa-lightbulb me-2"></span>PLAN</h5>
                            <h3>Blueprint &amp; design </h3>
                            <p>With Falcon as your guide, now you have a fine-tuned state of the earth tool to make your wireframe a reality.</p>
                        </div>
                    </div>
                    <div class="row flex-center mt-7">
                        <div class="col-md col-lg-5 col-xl-4 pe-lg-6 order-md-2"><img class="img-fluid px-6 px-md-0" src="<?= Url::to('@web/img/49.png') ?>" alt="" /></div>
                        <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0">
                            <h5 class="text-info"> <span class="far fa-object-ungroup me-2"></span>BUILD</h5>
                            <h3>38 Sets of components</h3>
                            <p>Build any UI effortlessly with Falcon's robust set of layouts, 38 sets of built-in elements, carefully chosen colors, typography, and css helpers.</p>
                        </div>
                    </div>
                    <div class="row flex-center mt-7">
                        <div class="col-md col-lg-5 col-xl-4 ps-lg-6"><img class="img-fluid px-6 px-md-0" src="<?= Url::to('@web/img/48.png') ?>" alt="" /></div>
                        <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0">
                            <h5 class="text-success"><span class="far fa-paper-plane me-2"></span>DEPLOY</h5>
                            <h3>Review and test</h3>
                            <p>From IE to iOS, rigorously tested and optimized Falcon will give the near perfect finishing to your webapp; from the landing page to the logout screen.</p>
                        </div>
                    </div>
                </div>
                <!-- end of .container-->

            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->




            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="bg-light text-center">

                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h1 class="fs-2 fs-sm-4 fs-md-5">Here's what's in it for you</h1>
                            <p class="lead">Things you will get right out of the box with Falcon.</p>
                        </div>
                    </div>
                    <div class="row mt-6">
                        <div class="col-lg-4">
                            <div class="card card-span h-100">
                                <div class="card-span-img"><span class="fab fa-sass fs-4 text-info"></span></div>
                                <div class="card-body pt-6 pb-4">
                                    <h5 class="mb-2">Bootstrap 5.x</h5>
                                    <p>Build your webapp with the world's most popular front-end component library along with Falcon's 32 sets of carefully designed elements.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-6 mt-lg-0">
                            <div class="card card-span h-100">
                                <div class="card-span-img"><span class="fab fa-node-js fs-5 text-success"></span></div>
                                <div class="card-body pt-6 pb-4">
                                    <h5 class="mb-2">SCSS &amp; Javascript files</h5>
                                    <p>With your purchased copy of Falcon, you will get all the uncompressed & documented SCSS and Javascript source code files.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-6 mt-lg-0">
                            <div class="card card-span h-100">
                                <div class="card-span-img"><span class="fab fa-gulp fs-6 text-danger"></span></div>
                                <div class="card-body pt-6 pb-4">
                                    <h5 class="mb-2">Gulp based workflow</h5>
                                    <p>All the painful or time-consuming tasks in your development workflow such as compiling the SCSS or transpiring the JS are automated.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of .container-->

            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->




            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="bg-200 text-center">

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-9 col-xl-8">
                            <div class="swiper-container theme-slider" data-swiper='{"autoplay":true,"spaceBetween":5,"loop":true,"loopedSlides":5,"slideToClickedSlide":true}'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="px-5 px-sm-6">
                                            <p class="fs-sm-1 fs-md-2 fst-italic text-dark">Falcon is the best option if you are looking for a theme built with Bootstrap. On top of that, Falcon&apos;s creators and support staff are very brilliant and attentive to users&apos; needs.</p>
                                            <p class="fs-0 text-600">- Scott Tolinski, Web Developer</p><img class="w-auto mx-auto" src="../assets/img/logos/google.png" alt="" height="45" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="px-5 px-sm-6">
                                            <p class="fs-sm-1 fs-md-2 fst-italic text-dark">We&apos;ve become fanboys! Easy to change the modular design, great dashboard UI, enterprise-class support, fast loading time. What else do you want from a Bootstrap Theme?</p>
                                            <p class="fs-0 text-600">- Jeff Escalante, Developer</p><img class="w-auto mx-auto" src="../assets/img/logos/netflix.png" alt="" height="30" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="px-5 px-sm-6">
                                            <p class="fs-sm-1 fs-md-2 fst-italic text-dark">When I first saw Falcon, I was totally blown away by the care taken in the interface. It felt like something that I&apos;d really want to use and something I could see being a true modern replacement to the current class of Bootstrap themes.</p>
                                            <p class="fs-0 text-600">- Liam Martens, Designer</p><img class="w-auto mx-auto" src="../assets/img/logos/paypal.png" alt="" height="45" />
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-nav">
                                    <div class="swiper-button-next swiper-button-white"></div>
                                    <div class="swiper-button-prev swiper-button-white"> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of .container-->

            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->




            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="light bg-dark">

                <div class="bg-holder overlay" style="background-image:url(../assets/img/generic/bg-2.jpg);background-position: center top;">
                </div>
                <!--/.bg-holder-->

                <div class="container">
                    <div class="row justify-content-center text-center">
                        <div class="col-lg-8">
                            <p class="fs-3 fs-sm-4 text-white">Join our community of 20,000+ developers and content creators on their mission to build better sites and apps.</p>
                            <button class="btn btn-outline-light border-2 rounded-pill btn-lg mt-4 fs-0 py-2" type="button">Start your webapp</button>
                        </div>
                    </div>
                </div>
                <!-- end of .container-->

            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->




            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="bg-dark pt-8 pb-4 light">

                <div class="container">
                    <div class="position-absolute btn-back-to-top bg-dark"><a class="text-600" href="#banner" data-bs-offset-top="0" data-scroll-to="#banner"><span class="fas fa-chevron-up" data-fa-transform="rotate-45"></span></a></div>
                    <div class="row">
                        <div class="col-lg-4">
                            <h5 class="text-uppercase text-white opacity-85 mb-3">Our Mission</h5>
                            <p class="text-600">Falcon enables front end developers to build custom streamlined user interfaces in a matter of hours, while it gives backend developers all the UI elements they need to develop their web app.And it's rich design can be easily integrated with backends whether your app is based on ruby on rails, laravel, express or any other server side system.</p>
                            <div class="icon-group mt-4"><a class="icon-item bg-white text-facebook" href="#!"><span class="fab fa-facebook-f"></span></a><a class="icon-item bg-white text-twitter" href="#!"><span class="fab fa-twitter"></span></a><a class="icon-item bg-white text-google-plus" href="#!"><span class="fab fa-google-plus-g"></span></a><a class="icon-item bg-white text-linkedin" href="#!"><span class="fab fa-linkedin-in"></span></a><a class="icon-item bg-white" href="#!"><span class="fab fa-medium-m"></span></a></div>
                        </div>
                        <div class="col ps-lg-6 ps-xl-8">
                            <div class="row mt-5 mt-lg-0">
                                <div class="col-6 col-md-3">
                                    <h5 class="text-uppercase text-white opacity-85 mb-3">Company</h5>
                                    <ul class="list-unstyled">
                                        <li class="mb-1"><a class="link-600" href="#!">About</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">Contact</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">Careers</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">Blog</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">Terms</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">Privacy</a></li>
                                        <li><a class="link-600" href="#!">Imprint</a></li>
                                    </ul>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h5 class="text-uppercase text-white opacity-85 mb-3">Product</h5>
                                    <ul class="list-unstyled">
                                        <li class="mb-1"><a class="link-600" href="#!">Features</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">Roadmap</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">Changelog</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">Pricing</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">Docs</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">System Status</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">Agencies</a></li>
                                        <li class="mb-1"><a class="link-600" href="#!">Enterprise</a></li>
                                    </ul>
                                </div>
                                <div class="col mt-5 mt-md-0">
                                    <h5 class="text-uppercase text-white opacity-85 mb-3">From the Blog</h5>
                                    <ul class="list-unstyled">
                                        <li>
                                            <h5 class="fs-0 mb-0"><a class="link-600" href="#!"> Interactive graphs and charts</a></h5>
                                            <p class="text-600 opacity-50">Jan 15 &bull; 8min read </p>
                                        </li>
                                        <li>
                                            <h5 class="fs-0 mb-0"><a class="link-600" href="#!"> Lifetime free updates</a></h5>
                                            <p class="text-600 opacity-50">Jan 5 &bull; 3min read &starf;</p>
                                        </li>
                                        <li>
                                            <h5 class="fs-0 mb-0"><a class="link-600" href="#!"> Merry Christmas From us</a></h5>
                                            <p class="text-600 opacity-50">Dec 25 &bull; 2min read</p>
                                        </li>
                                        <li>
                                            <h5 class="fs-0 mb-0"><a class="link-600" href="#!"> The New Falcon Theme</a></h5>
                                            <p class="text-600 opacity-50">Dec 23 &bull; 10min read </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of .container-->

            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->




            <!-- ============================================-->
            <!-- <section> begin ============================-->
            <section class="py-0 bg-dark light">

                <div>
                    <hr class="my-0 text-600 opacity-25" />
                    <div class="container py-3">
                        <div class="row justify-content-between fs--1">
                            <div class="col-12 col-sm-auto text-center">
                                <p class="mb-0 text-600 opacity-85">
                                    <?= Yii::$app->params['institution'] ?> 
                                    <span class="d-none d-sm-inline-block">| </span>
                                    <br class="d-sm-none" /> <?= date("Y") ?> &copy; 
                                    <a class="text-white opacity-85" href="<?= Yii::$app->params['website'] ?>">
                                        <?= Yii::$app->params['institutionShortName'] ?>
                                    </a>
                                </p>
                            </div>
                            <div class="col-12 col-sm-auto text-center">
                                <p class="mb-0 text-600 opacity-85">v1.0</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of .container-->

            </section>
            <!-- <section> close ============================-->
            <!-- ============================================-->


            <div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog" aria-labelledby="authentication-modal-label" aria-hidden="true">
                <div class="modal-dialog mt-6" role="document">
                    <div class="modal-content border-0">
                        <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                            <div class="position-relative z-index-1 light">
                                <h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>
                                <p class="fs--1 mb-0 text-white">Please create your free Falcon account</p>
                            </div>
                            <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-4 px-5">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label" for="modal-auth-name">Name</label>
                                    <input class="form-control" type="text" autocomplete="on" id="modal-auth-name" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="modal-auth-email">Email address</label>
                                    <input class="form-control" type="email" autocomplete="on" id="modal-auth-email" />
                                </div>
                                <div class="row gx-2">
                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="modal-auth-password">Password</label>
                                        <input class="form-control" type="password" autocomplete="on" id="modal-auth-password" />
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="modal-auth-confirm-password">Confirm Password</label>
                                        <input class="form-control" type="password" autocomplete="on" id="modal-auth-confirm-password" />
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="modal-auth-register-checkbox" />
                                    <label class="form-label" for="modal-auth-register-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button>
                                </div>
                            </form>
                            <div class="position-relative mt-5">
                                <hr class="bg-300" />
                                <div class="divider-content-center">or register with</div>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google</a></div>
                                <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php
        $this->endBody();
        ?>
    </body>
</html>
<?php
$this->endPage();

