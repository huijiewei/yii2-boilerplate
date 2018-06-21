<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m180621_040655_create_admin_table extends Migration
{
    private $adminTableName = '{{%admin}}';
    private $groupTableName = '{{%admin_group}}';
    private $routeTableName = '{{%admin_route}}';
    private $tokenTableName = '{{%admin_token}}';

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql' || $this->db->driverName === 'mariadb') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $this->createTable($this->adminTableName, [
            'id' => $this->primaryKey(),
            'groupId' => $this->integer()->notNull()->defaultValue(0),
            'phone' => $this->string(20)->notNull()->defaultValue(''),
            'password' => $this->string(90)->notNull()->defaultValue(''),
            'authKey' => $this->string(30)->notNull()->defaultValue(''),
            'displayName' => $this->string(20)->notNull()->defaultValue(''),
            'displayIcon' => $this->string(255)->notNull()->defaultValue(''),
            'createdAt' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex('phone', $this->adminTableName, 'phone', true);
        $this->createIndex('groupId', $this->adminTableName, 'groupId');

        $this->createTable($this->groupTableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->createTable($this->routeTableName, [
            'id' => $this->primaryKey(),
            'groupId' => $this->integer()->notNull()->defaultValue(0),
            'route' => $this->string(50)->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->createIndex('groupId', $this->routeTableName, 'groupId');

        $this->createTable($this->tokenTableName, [
            'id' => $this->primaryKey(),
            'adminId' => $this->integer()->notNull()->defaultValue(0),
            'accessType' => $this->string(20)->notNull()->defaultValue(''),
            'accessToken' => $this->string(60)->notNull()->defaultValue(''),
            'updatedAt' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex('groupId', $this->tokenTableName, 'adminId');
        $this->createIndex('accessToken', $this->tokenTableName, ['accessType', 'accessToken']);
    }

    public function safeDown()
    {
        $this->dropTable($this->adminTableName);
        $this->dropTable($this->groupTableName);
        $this->dropTable($this->routeTableName);
        $this->dropTable($this->tokenTableName);
    }
}
