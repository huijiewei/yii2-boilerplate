<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/8
 * Time: 09:14
 */

namespace app\core\components\auth;

class HttpHeaderAuth extends \yii\filters\auth\HttpHeaderAuth
{
    use AuthTrait;
}
