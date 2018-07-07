<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:49
 */

namespace app\core\components;

class WebController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function render($view, $params = [])
    {
        return parent::render($this->changeTemplatesViewPath($view), $params);
    }

    private function changeTemplatesViewPath($view)
    {
        if ((strncmp($view, '/', 1) !== 0 || strncmp($view, '@', 1) !== 0)) {
            $view = '/templates/' . $this->id . '/' . $view;
        }

        return $view;
    }

    /**
     * @inheritdoc
     */
    public function renderPartial($view, $params = [])
    {
        return parent::renderPartial($this->changeTemplatesViewPath($view), $params);
    }
}
