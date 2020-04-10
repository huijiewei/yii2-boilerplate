<?php

namespace app\modules\wechat;

use app\core\components\WebController as WebController;
use huijiewei\wechat\authorizes\WechatAuthorize;
use huijiewei\wechat\Wechat;

class Controller extends WebController
{
    protected $wechatOpenId = '';
    protected $wechatUserInfo = null;

    public function beforeAction($action)
    {
        if (Wechat::getIsWechatClient()) {
            $wechatAuthorize = new WechatAuthorize([
                'wechat' => 'wechat',
            ]);

            if (!$wechatAuthorize->isScopeBase()) {
                return $wechatAuthorize->authorizeRequired()->send();
            }

            $this->wechatOpenId = $wechatAuthorize->getWechatOpenId();
        }

        return parent::beforeAction($action);
    }
}
