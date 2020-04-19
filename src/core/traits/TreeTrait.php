<?php

namespace app\core\traits;

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
    private static $allCacheKey = false;
    private static $treeCacheKey = false;

    /**
     * @param bool $withSelf
     *
     * @return array
     */
    public function getChildrenIds($withSelf = false)
    {
        return static::getChildrenIdsById($this->id, $withSelf);
    }

    /**
     * @param $id
     * @param bool $withSelf
     *
     * @return array
     */
    public static function getChildrenIdsById($id, $withSelf = false)
    {
        $ids = $withSelf ? [$id] : [];

        $tree = static::getChildrenById($id);

        return array_merge($ids, static::getItemIdsInTree($tree));
    }

    /**
     * @param $id
     *
     * @return null|array
     */
    public static function getChildrenById($id)
    {
        $node = static::getNodeInTreeById($id, static::getTree());

        if ($node && isset($node['children']) && !empty($node['children'])) {
            return $node['children'];
        }

        return [];
    }

    /**
     * @param $id
     * @param $tree
     * @return array|null
     */
    private static function getNodeInTreeById($id, $tree)
    {
        $result = null;

        foreach ($tree as $item) {
            if ($result !== null) {
                break;
            }

            if ($item['id'] == $id) {
                $result = $item;
                break;
            } elseif (isset($item['children']) && !empty($item['children'])) {
                $result = static::getNodeInTreeById($id, $item['children']);
            }
        }

        return $result;
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

        $tree = static::buildTree(static::getAll());

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
    public static function getAll()
    {
        $cacheKey = static::getAllCacheKey();

        $data = \Yii::$app->getCache()->get($cacheKey);

        if ($data !== false) {
            return $data;
        }

        $data = static::find()->indexBy('id')->asArray()->all();

        \Yii::$app->getCache()->set($cacheKey, $data);

        return $data;
    }

    protected static function getAllCacheKey()
    {
        if (static::$allCacheKey === false) {
            static::$allCacheKey = get_called_class() . '\allCache';
        }

        return static::$allCacheKey;
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
            'parents',
            'children',
        ];
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return static::getChildrenById($this->id);
    }

    /**
     * @return array
     */
    public function getParents()
    {
        return static::getParentsById($this->parentId);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public static function getParentsById($id)
    {
        $all = static::getAll();

        $parents = [];

        $parent = static::getItemInListById($id, $all);

        while ($parent != null) {
            $parents[] = $parent;
            $parent = static::getItemInListById($parent['parentId'], $all);
        }

        return array_reverse($parents);
    }

    /**
     * @param $id
     * @param $list
     *
     * @return null
     */
    private static function getItemInListById($id, $list)
    {
        foreach ($list as $item) {
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
        \Yii::$app->getCache()->delete(static::getAllCacheKey());
    }
}
