<?php
// phpcs:ignoreFile

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180726_011105_create_user_table extends Migration
{
    private $userTableName = '{{%user}}';

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql' || $this->db->driverName === 'mariadb') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $this->createTable($this->userTableName, [
            'id' => $this->primaryKey(),
            'phone' => $this->string(20)->notNull()->defaultValue(''),
            'password' => $this->string(90)->notNull()->defaultValue(''),
            'authKey' => $this->string(60)->notNull()->defaultValue(''),
            'display' => $this->string(20)->notNull()->defaultValue(''),
            'avatar' => $this->string(255)->notNull()->defaultValue(''),
            'createdAt' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'createdIp' => $this->string(32)->notNull()->defaultValue(''),
            'createdFrom' => $this->string(10)->notNull()->defaultValue(''),
        ], $tableOptions . ' AUTO_INCREMENT=10021');

        $this->createIndex('phone', $this->userTableName, 'phone', true);
        $this->createIndex('createdFrom', $this->userTableName, 'createdFrom');
    }

    public function safeDown()
    {
        $this->dropTable($this->userTableName);
    }
}
