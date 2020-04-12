<?php

namespace app\modules\mobile\spa;

class ManifestAssetBundle extends \app\core\components\ManifestAssetBundle
{
    public $manifestFile = 'mobile' . DIRECTORY_SEPARATOR . 'manifest.json';
}
