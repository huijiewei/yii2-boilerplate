<?php
/**
 * Created by PhpStorm.
 * User: Huijiewei
 * Date: 2017/1/5
 * Time: 上午10:55
 */

namespace app\core\widgets;

use yii\web\View;
use yii\widgets\Block;

class ScriptBlock extends Block
{
    public $key = null;

    public $pos = View::POS_END;

    public $scriptPattern = '/<(script.*?)>(?P<script_content>.+?)<(\/script.*?)>/si';

    public function run()
    {
        $block = ob_get_clean();

        if ($this->renderInPlace) {
            throw new \Exception('not implemented yet ! ');
        }

        $block = trim($block);

        if (preg_match($this->scriptPattern, $block, $matches)) {
            $block = $matches['script_content'];
        }

        $this->getView()->registerJs($block, $this->pos, $this->key);
    }
}
