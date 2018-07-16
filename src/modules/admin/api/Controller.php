<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 23:29
 */

namespace app\modules\admin\api;

use app\core\components\AccessControl;
use app\core\components\ActiveRecord;
use app\core\components\HttpHeaderAuth;
use app\core\components\Model;
use app\core\components\RestController;
use app\core\models\admin\Admin;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\validators\FilterValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\web\Response;

/**
 * Class Controller
 *
 * @property Admin $identity
 * @method Admin getIdentity()
 *
 * @package app\modules\admin\api
 */
abstract class Controller extends RestController
{
    public function behaviors()
    {
        return [
            'content' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'cors' => [
                'class' => Cors::class,
            ],
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'auth' => [
                'class' => HttpHeaderAuth::class,
                'header' => 'X-Access-Token',
                'clientId' => $this->getClientId(),
                'optional' => [
                    'auth/login',
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'except' => [
                    'site/*', 'auth/*',
                ],
            ],
            'rate' => [
                'class' => RateLimiter::class,
            ],
        ];
    }

    public function message($message, $data = [])
    {
        return array_merge(['message' => $message], $data);
    }

    public function getClientId()
    {
        return \Yii::$app->getRequest()->getHeaders()->get('X-Client-Id', '');
    }

    /**
     * @param $model Model|ActiveRecord
     *
     * @return array
     */
    public function formatModelRules($model)
    {
        $result = [];

        $validators = $model->getValidators();

        foreach ($validators as $validator) {
            if ($validator instanceof FilterValidator && $validator->filter == 'trim') {
                continue;
            }

            foreach ($validator->attributes as $attribute) {
                if (!isset($result[$attribute])) {
                    $result[$attribute] = [];
                }

                if ($validator instanceof RequiredValidator) {
                    $result[$attribute][] = [
                        'required' => true,
                        'message' => '请输入' . $model->getAttributeLabel($attribute),
                        'trigger' => 'blur'
                    ];

                    continue;
                }

                if ($validator instanceof StringValidator) {
                    $result[$attribute][] = [
                        'type' => 'string',
                        'min' => $validator->min,
                        'max' => $validator->max,
                        'message' => '长度在 ' . $validator->min . ' 到 ' . $validator->max . ' 个字符',
                        'trigger' => 'blur'
                    ];

                    continue;
                }
            }
        }

        return $result;
    }
}
