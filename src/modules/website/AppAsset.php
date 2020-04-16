<?php

namespace app\modules\website;

use engine\assets\AnimateAsset;
use huijiewei\bootbox\BootboxAsset;
use huijiewei\fontawesome\FontAwesomeAsset;
use huijiewei\noty\NotyAsset;
use huijiewei\nprogress\NProgressAsset;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class AppAsset
 * @package app\website
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot/statics';
    /**
     * @var string
     */
    public $baseUrl = '@web/statics';

    /**
     * @var array
     */
    public $css = [
        'styles/border.radius.css',
        'styles/app.css',
        'styles/app.website.css?v2019110902',
    ];

    /**
     * @var array
     */
    public $js = [
        'scripts/ajax.js',
        'scripts/ajax.button.js',
        'scripts/ajax.form.js',
        'scripts/login.modal.js',
        'scripts/register.modal.js',
        'scripts/tmpl.min.js',
        'scripts/wow.min.js',
        'scripts/app.js',
        'scripts/app.website.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
    ];
}
