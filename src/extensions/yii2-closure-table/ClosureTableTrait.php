<?php

namespace huijiewei\closuretable;

use yii\base\Event;
use yii\base\InvalidArgumentException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * Trait ClosureTableTrait
 *
 * @method static Connection getDb()
 * @method static ActiveQuery find()
 *
 * @method bool hasAttribute($attribute)
 * @method on($name, $handler, $data = null, $append = true)
 *
 * @method ActiveQuery hasMany($class, array $link) see [[BaseActiveRecord::hasMany()]] for more info
 * @method ActiveQuery hasOne($class, array $link) see [[BaseActiveRecord::hasOne()]] for more info
 *
 * @package huijiewei\closuretable
 */
trait ClosureTableTrait
{
    public static function rebuildClosureTable()
    {
        static::getDb()->createCommand()->delete(static::getClosureTableName())->execute();

        /* @var $all array */
        $all = static::find()->select(['id', 'parentId'])->asArray()->all();

        foreach ($all as $item) {
            static::insertClosureTable($item['id'], $item['parentId']);
        }
    }

    /**
     * @return string
     */
    public static function getClosureTableName()
    {
        return '{{%' . Inflector::camel2id(StringHelper::basename(get_called_class()), '_') . '_closure}}';
    }

    private static function insertClosureTable($id, $parentId)
    {
        $ancestorId = $parentId;
        $descendantId = $id;

        $closureTableName = static::getDb()->quoteTableName(static::getClosureTableName());

        $sql = "
            INSERT INTO {$closureTableName} (ancestor, descendant, distance)
            SELECT tbl.ancestor, {$descendantId}, tbl.distance + 1
            FROM {$closureTableName} AS tbl
            WHERE tbl.descendant = {$ancestorId}
            UNION ALL
            SELECT {$descendantId}, {$descendantId}, 0
            ON DUPLICATE KEY UPDATE distance = VALUES (distance)
            ";

        static::getDb()->createCommand($sql)->execute();
    }

    public function init()
    {
        if (!$this->hasAttribute('parentId') && $this->parentId == null) {
            throw new InvalidArgumentException('活动记录必须有 parentId 字段');
        }

        $this->on(ActiveRecord::EVENT_AFTER_DELETE, function (Event $event) {
        });

        $this->on(ActiveRecord::EVENT_AFTER_INSERT, function (Event $event) {
            static::insertClosureTable($event->sender->id, $event->sender->parentId);
        });

        $this->on(ActiveRecord::EVENT_AFTER_UPDATE, function (Event $event) {
            if ($event->sender->isAttributeChanged('parentId')) {
            }
        });
    }
}
