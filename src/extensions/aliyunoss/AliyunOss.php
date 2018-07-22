<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/22
 * Time: 01:14
 */

namespace app\extensions\aliyunoss;

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
}
