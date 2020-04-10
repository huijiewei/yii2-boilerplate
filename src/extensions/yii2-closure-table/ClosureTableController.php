<?php

namespace huijiewei\closuretable;

use yii\base\InvalidArgumentException;
use yii\console\Controller;
use yii\db\ActiveRecord;
use yii\db\Migration;

class ClosureTableController extends Controller
{
    /**
     * @param string $modelClass
     */
    public function actionMake($modelClass)
    {
        $model = $this->buildModel($modelClass);

        $closureTableName = $model::getClosureTableName();

        $migration = new Migration(['db' => $model::getDb()]);

        $migration->createTable($closureTableName, [
            'id' => $migration->primaryKey(),
            'ancestor' => $migration->integer()->notNull()->defaultValue(0),
            'descendant' => $migration->integer()->notNull()->defaultValue(0),
            'distance' => $migration->integer()->notNull()->defaultValue(0)
        ]);

        $this->stdout('创建成功');
    }

    /**
     * @param $modelClass
     *
     * @return ActiveRecord|ClosureTableTrait
     */
    private function buildModel($modelClass)
    {
        /* @var $model ActiveRecord|ClosureTableTrait */
        $model = 'app\\core\\models\\' . str_replace('/', '\\', $modelClass);

        if (!class_exists($model)) {
            throw new InvalidArgumentException($modelClass . ' 不存在');
        }

        if (!method_exists($model, 'getClosureTableName')) {
            throw new InvalidArgumentException($modelClass . ' 中不存在 getClosureTableName，请确认已 use ClosureTableTrait');
        }

        return $model;
    }

    /**
     * @param string $modelClass
     */
    public function actionUnmake($modelClass)
    {
        $model = $this->buildModel($modelClass);

        $closureTableName = $model::getClosureTableName();

        $migration = new Migration(['db' => $model::getDb()]);

        $migration->dropTable($closureTableName);

        $this->stdout('删除成功');
    }
}
