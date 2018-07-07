<?php
/** @noinspection PhpUndefinedClassInspection */

/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/7
 * Time: 15:40
 */

namespace app\core\traits;

use yii\db\Expression;

/**
 * Trait SoftDeleteTrait
 *
 * @package app\core\traits
 */
trait SoftDeleteTrait
{
    public static $softDelete = true;

    public static $softDeleteAttribute = 'deleted';
    public static $softDeleteTimeAttribute = 'deletedAt';

    public function remove()
    {
        $softDeleteAttribute = static::$softDeleteAttribute;
        $softDeleteTimeAttribute = static::$softDeleteTimeAttribute;

        $this->$softDeleteAttribute = 1;
        $this->$softDeleteTimeAttribute = new Expression('CURRENT_TIMESTAMP');

        $this->save(false, [$softDeleteAttribute, $softDeleteTimeAttribute]);
    }

    public function restore()
    {
        $softDeleteAttribute = static::$softDeleteAttribute;

        $this->$softDeleteAttribute = 0;

        $this->save(false, [$softDeleteAttribute]);
    }

    /**
     *  不允许删除
     *
     * @return bool
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if (static::$softDelete) {
            $this->addError('id', '不支持直接删除，请使用 remove() 方法软删除');

            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function getIsDeleted()
    {
        $softDeleteAttribute = static::$softDeleteAttribute;

        return $this->$softDeleteAttribute == 1;
    }
}
