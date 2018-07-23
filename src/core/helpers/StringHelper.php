<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/7
 * Time: 12:44
 */

namespace app\core\helpers;

use Hidehalo\Nanoid\Client;
use yii\helpers\BaseStringHelper;

class StringHelper extends BaseStringHelper
{
    /**
     * @param $string
     * @param $trim
     *
     * @return bool|string
     */
    public static function startsTrim($string, $trim)
    {
        if (self::startsWith($string, $trim)) {
            return substr($string, strlen($trim));
        } else {
            return $string;
        }
    }

    /**
     * @param $string
     * @param $trim
     *
     * @return bool|string
     */
    public static function endsTrim($string, $trim)
    {
        if (self::endsWith($string, $trim)) {
            return substr($string, 0, -strlen($trim));
        } else {
            return $string;
        }
    }

    /**
     * @param $phoneNumber
     *
     * @return bool
     */
    public static function isPhoneNumber($phoneNumber)
    {
        return preg_match('/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[0-9]|6[0-9]|9[0-9])\\d{8}$/', $phoneNumber);
    }

    /**
     * @param $number
     *
     * @return bool
     */
    public static function isNumber($number)
    {
        if (!preg_match('/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/', StringHelper::normalizeNumber($number))) {
            return false;
        }

        return true;
    }

    /**
     * @param $integer
     *
     * @return bool
     */
    public static function isInteger($integer)
    {
        if (!preg_match('/^\s*[+-]?\d+\s*$/', StringHelper::normalizeNumber($integer))) {
            return false;
        }

        return true;
    }

    /**
     * @param int $size
     *
     * @return string
     */
    public static function generateNanoId($size = 32)
    {
        $client = new Client();

        return $client->formatedId($alphabet = '3456789abcdefghgkmnpqrstuvwxy', $size);
    }
}
