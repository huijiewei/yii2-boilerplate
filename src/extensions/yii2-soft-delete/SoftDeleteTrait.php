<?php

namespace huijiewei\softdelete;

use yii\db\Expression;

/**
 * Trait SoftDeleteTrait
 *
 * @method bool save(bool $runValidation, array | null $attributeNames)
 * @method addError($attribute, string $error)
 *
 * @package app\core\traits
 */
trait SoftDeleteTrait
{
    protected static $deletedAtAttribute = 'deletedAt';

    public function softDelete()
    {
        if (!static::beforeDelete()) {
            return false;
        }

        $deletedAtAttribute = static::$deletedAtAttribute;

        $this->$deletedAtAttribute = new Expression('CURRENT_TIMESTAMP');

        $this->save(false, [$deletedAtAttribute]);

        return true;
    }

    /**
     *  不允许删除
     *
     * @return bool
     */
    public function beforeDelete()
    {
        if (!static::beforeDelete()) {
            return false;
        }

        $this->addError('id', '不支持直接删除，请使用 softDelete() 方法软删除');

        return false;
    }

    public function restore()
    {
        $deletedAtAttribute = static::$deletedAtAttribute;

        $this->$deletedAtAttribute = 0;

        $this->save(false, [$deletedAtAttribute]);
    }

    /**
     * @return bool
     */
    public function getIsTrashed()
    {
        return $this->{static::$deletedAtAttribute} > 0;
    }
}
