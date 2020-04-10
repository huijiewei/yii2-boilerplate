<?php

namespace app\core\widgets;

use yii\widgets\Block;

class StyleBlock extends Block
{
    public $key = null;

    public $options = [];

    public $stylePattern = '/<(style.*?)>(?P<style_content>.+?)<(\/style.*?)>/si';

    public function run()
    {
        $block = ob_get_clean();

        if ($this->renderInPlace) {
            throw new \Exception('not implemented yet ! ');
        }

        $block = trim($block);

        if (preg_match($this->stylePattern, $block, $matches)) {
            $block = $matches['style_content'];
        }

        $this->getView()->registerCss($block, $this->options, $this->key);
    }
}
