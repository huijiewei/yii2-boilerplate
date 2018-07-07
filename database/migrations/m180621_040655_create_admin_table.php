<?php
// phpcs:ignoreFile

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m180621_040655_create_admin_table extends Migration
{
    private $adminTableName = '{{%admin}}';
    private $adminAccessTokenTableName = '{{%admin_access_token}}';
    private $adminGroupTableName = '{{%admin_group}}';
    private $adminGroupAclTableName = '{{%admin_group_acl}}';

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

        $this->createTable($this->adminAccessTokenTableName, [
            'id' => $this->primaryKey(),
            'adminId' => $this->integer()->notNull()->defaultValue(0),
            'clientId' => $this->string(20)->notNull()->defaultValue(''),
            'token' => $this->string(60)->notNull()->defaultValue(''),
            'updatedAt' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex('adminId', $this->adminAccessTokenTableName, ['adminId', 'clientId']);
        $this->createIndex('token', $this->adminAccessTokenTableName, ['token', 'clientId']);

        $this->createTable($this->adminGroupTableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->createTable($this->adminGroupAclTableName, [
            'id' => $this->primaryKey(),
            'groupId' => $this->integer()->notNull()->defaultValue(0),
            'actionId' => $this->string(50)->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->createIndex('groupId', $this->adminGroupAclTableName, 'groupId');
    }

    public function safeDown()
    {
        $this->dropTable($this->adminTableName);
        $this->dropTable($this->adminAccessTokenTableName);
        $this->dropTable($this->adminGroupTableName);
        $this->dropTable($this->adminGroupAclTableName);
    }
}
