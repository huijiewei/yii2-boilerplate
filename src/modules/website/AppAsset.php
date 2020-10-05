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
    ];

    /**
     * @var array
     */
    public $js = [
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
