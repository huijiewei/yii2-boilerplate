<?php

namespace app\core\components;

use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\helpers\Json;
use yii\web\View;

class ManifestAssetBundle extends BaseObject
{
    public $manifestFile = 'manifest.json';

    public $manifestPath = '@webroot/statics/build';

    public $js = [];
    public $css = [];
    public $etag = '';

    /**
     * @param $view View
     * @throws \yii\base\InvalidConfigException
     */
    public static function register($view)
    {
        /* @var $bundle ManifestAssetBundle */
        $bundle = \Yii::createObject(get_called_class());

        $responseHeaders = \Yii::$app->getResponse()->getHeaders();

        $responseHeaders->set('ETag', $bundle->etag);

        foreach ($bundle->js as $js) {
            $view->registerJsFile($js);
        }

        foreach ($bundle->css as $css) {
            $view->registerCssFile($css);
        }
    }

    public function init()
    {
        parent::init();

        $manifestPath = \Yii::getAlias($this->manifestPath);

        $manifestFile = $manifestPath . DIRECTORY_SEPARATOR . $this->manifestFile;

        if (!file_exists($manifestFile)) {
            throw new InvalidArgumentException('manifest.json is not exist.');
        }

        $this->parseManifestFile($manifestFile);
    }

    protected function parseManifestFile($manifestFile)
    {
        $text = file_get_contents($manifestFile);

        $this->etag = md5($text);

        $json = Json::decode($text);

        foreach ($json as $file => $url) {
            $fileExt = pathinfo($file, PATHINFO_EXTENSION);

            if ($fileExt == 'js') {
                $this->js[] = $url;
            }

            if ($fileExt == 'css') {
                $this->css[] = $url;
            }
        }
    }
}
