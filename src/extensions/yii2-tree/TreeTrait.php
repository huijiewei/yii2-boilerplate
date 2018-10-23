<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/10/23
 * Time: 21:41
 */

namespace huijiewei\tree;

use yii\base\InvalidArgumentException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Trait TreeTrait
 *
 * @method static ActiveQuery find()
 *
 * @method bool hasAttribute($attribute)
 * @method on($name, $handler, $data = null, $append = true)
 *
 * @property integer $id
 * @property integer $parentId
 *
 * @package huijiewei\tree
 */
trait TreeTrait
{
    private static $treeCacheKey = false;
    private static $dataCacheKey = false;

    /**
     * @param bool $withSelf
     *
     * @return array
     */
    public function getDescendantIds($withSelf = false)
    {
        return static::getDescendantIdsById($this->id, $withSelf);
    }

    /**
     * @param $id
     * @param bool $withSelf
     *
     * @return array
     */
    public static function getDescendantIdsById($id, $withSelf = false)
    {
        $ids = $withSelf ? [$id] : [];

        $tree = static::getDescendantById($id);

        return array_merge($ids, static::getItemIdsInTree($tree));
    }

    /**
     * @param $id
     *
     * @return null|array
     */
    public static function getDescendantById($id)
    {
        return static::getItemInTreeById($id, static::getTree());
    }

    private static function getItemInTreeById($id, $tree)
    {
        foreach ($tree as $item) {
            if ($item['id'] == $id) {
                return isset($item['children']) ? $item['children'] : null;
            }

            if (isset($item['children']) && is_array($item['children'])) {
                return static::getItemInTreeById($id, $item['children']);
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public static function getTree()
    {
        $cacheKey = static::getTreeCacheKey();

        $tree = \Yii::$app->getCache()->get($cacheKey);

        if ($tree !== false) {
            return $tree;
        }

        $tree = static::buildTree(static::getData());

        \Yii::$app->getCache()->set($cacheKey, $tree);

        return $tree;
    }

    protected static function getTreeCacheKey()
    {
        if (static::$treeCacheKey === false) {
            static::$treeCacheKey = get_called_class() . '\treeCache';
        }

        return static::$treeCacheKey;
    }

    private static function buildTree($data)
    {
        if (empty($data)) {
            return [];
        }

        $tree = [];

        foreach ($data as $item) {
            if (isset($data[$item['parentId']])) {
                $data[$item['parentId']]['children'][] = &$data[$item['id']];
            } else {
                $tree[] = &$data[$item['id']];
            }
        }

        return $tree;
    }

    /**
     * @return array
     */
    public static function getData()
    {
        $cacheKey = static::getDataCacheKey();

        $data = \Yii::$app->getCache()->get($cacheKey);

        if ($data !== false) {
            return $data;
        }

        $data = static::find()->indexBy('id')->asArray()->all();

        \Yii::$app->getCache()->set($cacheKey, $data);

        return $data;
    }

    protected static function getDataCacheKey()
    {
        if (static::$dataCacheKey === false) {
            static::$dataCacheKey = get_called_class() . '\dataCache';
        }

        return static::$dataCacheKey;
    }

    private static function getItemIdsInTree($tree)
    {
        $ids = [];

        foreach ($tree as $item) {
            $ids[] = intval($item['id']);

            if (isset($item['children']) && is_array($item['children'])) {
                $ids = array_merge($ids, static::getItemIdsInTree($item['children']));
            }
        }

        return $ids;
    }

    public function extraFields()
    {
        return [
            'ancestor',
            'descendant',
        ];
    }

    /**
     * @return array
     */
    public function getDescendant()
    {
        return static::getDescendantById($this->id);
    }

    /**
     * @return array
     */
    public function getAncestor()
    {
        return static::getAncestorById($this->parentId);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public static function getAncestorById($id)
    {
        $data = static::getData();

        $ancestor = [];

        $parent = static::getItemInDataById($id, $data);

        while ($parent != null) {
            $ancestor[] = $parent;
            $parent = static::getItemInDataById($parent['parentId'], $data);
        }

        return array_reverse($ancestor);
    }

    /**
     * @param $id
     * @param $data
     *
     * @return null
     */
    private static function getItemInDataById($id, $data)
    {
        foreach ($data as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }

        return null;
    }

    public function init()
    {
        if (!$this->hasAttribute('parentId') && $this->parentId == null) {
            throw new InvalidArgumentException('活动记录必须有 parentId 字段');
        }

        $this->on(ActiveRecord::EVENT_AFTER_DELETE, function () {
            static::clearCache();
        });

        $this->on(ActiveRecord::EVENT_AFTER_INSERT, function () {
            static::clearCache();
        });

        $this->on(ActiveRecord::EVENT_AFTER_UPDATE, function () {
            static::clearCache();
        });
    }

    protected static function clearCache()
    {
        \Yii::$app->getCache()->delete(static::getTreeCacheKey());
        \Yii::$app->getCache()->delete(static::getDataCacheKey());
    }
}
