<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/8
 * Time: 09:02
 */

namespace app\core\components\auth;

class CompositeAuth extends \yii\filters\auth\CompositeAuth
{
    use AuthTrait;
}
