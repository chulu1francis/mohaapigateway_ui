<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle {

    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@backend/web';
    public $css = [
        'vendors/overlayscrollbars/OverlayScrollbars.min.css',
        ['css/theme-rtl.min.css', 'id' => "style-rtl"],
        ['css/theme.min.css', 'id' => "style-default"],
        ['css/user-rtl.min.css', 'id' => "user-style-rtl"],
        ['css/user.min.css', 'id' => "user-style-default"],
        'css/material-icons.css'
    ];
    public $js = [
        'js/config.js',
        'vendors/overlayscrollbars/OverlayScrollbars.min.js',
        'vendors/popper/popper.min.js',
        'vendors/anchorjs/anchor.min.js',
        'vendors/is/is.min.js',
        'vendors/countup/countUp.umd.js',
        'vendors/fontawesome/all.min.js',
        'vendors/lodash/lodash.min.js',
        'vendors/list.js/list.min.js',
        'js/theme.js',
        'js/app.js',
        'https://polyfill.io/v3/polyfill.min.js?features=window.scroll',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
    ];

}
