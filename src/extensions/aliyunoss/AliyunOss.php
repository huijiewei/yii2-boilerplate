<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/22
 * Time: 01:14
 */

namespace app\extensions\aliyunoss;

use app\core\helpers\StringHelper;
use OSS\OssClient;
use yii\base\Component;
use yii\base\InvalidArgumentException;

class AliyunOss extends Component
{
    public $accessKeyId;
    public $accessKeySecret;
    public $endpoint;
    public $bucket;
    public $folder = '';

    private $ossClient;

    public function init()
    {
        parent::init();

        if (empty($this->accessKeyId)) {
            throw new InvalidArgumentException('请先设置 accessKeyId 属性');
        }

        if (empty($this->accessKeySecret)) {
            throw new InvalidArgumentException('请先设置 accessKeySecret 属性');
        }

        if (empty($this->endpoint)) {
            throw new InvalidArgumentException('请先设置 endpoint 属性');
        }

        if (empty($this->bucket)) {
            throw new InvalidArgumentException('请先设置 bucket 属性');
        }
    }

    /**
     * @return OssClient
     */
    public function getOssClient()
    {
        if ($this->ossClient === null) {
            $this->ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
        }

        return $this->ossClient;
    }

    public function getFormUpload()
    {
        $sizeLimit = 1024 * 1024;

        $month = \Yii::$app->getFormatter()->asDate('now', 'yyyyMM');
        $folder = StringHelper::endsTrim($this->folder, '/') . '/' . $month . '/';

        $policy = [
            'expiration' => \Yii::$app->getFormatter()->asDatetime('+10 minutes', 'php:Y-m-d\TH:i:s\Z'),
            'conditions' => [
                ['content-length-range', 0, $sizeLimit],
                ['starts-with', '$key', $folder],
            ]
        ];

        $policyJson = json_encode($policy);
        $policyBase64 = base64_encode($policyJson);

        $signature = base64_encode(hash_hmac('sha1', $policyBase64, $this->accessKeySecret, true));

        $data = [];

        $data['OSSAccessKeyId'] = $this->accessKeyId;
        $data['policy'] = $policyBase64;
        $data['Signature'] = $signature;
        $data['success_action_status'] = 201;

        return [
            'action' => 'https://' . $this->bucket . '.' . $this->endpoint,
            'data' => $data,
            'folder' => $folder,
            'sizeLimit' => $sizeLimit,
        ];
    }
}
