
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
       <?= Html::csrfMetaTags() ?>
        <title>Lib Portal | <?= Html::encode($this->title) ?></title>
        <!-- Basic -->
        <meta charset="UTF-8">

        <meta name="keywords" content="ID Room" />
        <meta name="description" content="UNZA ID Room App">
        <meta name="author" content="okler.net">
        <meta name="theme-color" content="#ffffff">
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="apple-touch-icon" sizes="180x180" href="<?= Url::to('@web/img/AU_logo.png') ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= Url::to('@web/img/AU_logo.png') ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= Url::to('@web/img/AU_logo.png') ?>">
        <link rel="shortcut icon" type="image/x-icon" href="<?= Url::to('@web/img/AU_logo.png') ?>">
        <?php $this->head() ?>
    </head>
    <body class="account-pages">
        <?php $this->beginBody() ?>
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
                <?= $content ?>
            </div>
        </main>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
