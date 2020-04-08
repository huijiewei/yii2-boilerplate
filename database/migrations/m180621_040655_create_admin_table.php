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
    private $adminGroupPermissionsTableName = '{{%admin_group_permissions}}';

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql' || $this->db->driverName === 'mariadb') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $this->createTable($this->adminTableName, [
            'id' => $this->primaryKey(),
            'adminGroupId' => $this->integer()->notNull()->defaultValue(0),
            'phone' => $this->string(20)->notNull()->defaultValue(''),
            'email' => $this->string(60)->notNull()->defaultValue(''),
            'password' => $this->string(90)->notNull()->defaultValue(''),
            'authKey' => $this->string(60)->notNull()->defaultValue(''),
            'name' => $this->string(20)->notNull()->defaultValue(''),
            'avatar' => $this->string(255)->notNull()->defaultValue(''),
            'createdAt' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions . ' AUTO_INCREMENT=1021');

        $this->createIndex('phone', $this->adminTableName, 'phone', true);
        $this->createIndex('email', $this->adminTableName, 'email', true);
        $this->createIndex('adminGroupId', $this->adminTableName, 'adminGroupId');

        $this->createTable($this->adminAccessTokenTableName, [
            'id' => $this->primaryKey(),
            'adminId' => $this->integer()->notNull()->defaultValue(0),
            'clientId' => $this->string(20)->notNull()->defaultValue(''),
            'accessToken' => $this->string(60)->notNull()->defaultValue(''),
            'remoteAddr' => $this->string(50)->notNull()->defaultValue(''),
            'userAgent' => $this->string(2048)->notNull()->defaultValue(''),
            'updatedAt' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex('adminId', $this->adminAccessTokenTableName, ['adminId', 'clientId']);
        $this->createIndex('accessToken', $this->adminAccessTokenTableName, ['accessToken', 'clientId']);

        $this->createTable($this->adminGroupTableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->defaultValue(''),
        ], $tableOptions . ' AUTO_INCREMENT=101');

        $this->createTable($this->adminGroupPermissionsTableName, [
            'id' => $this->primaryKey(),
            'adminGroupId' => $this->integer()->notNull()->defaultValue(0),
            'actionId' => $this->string(50)->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->createIndex('adminGroupId', $this->adminGroupPermissionsTableName, 'adminGroupId');

        $adminGroup = new \app\core\models\admin\AdminGroup();
        $adminGroup->name = '开发组';
        $adminGroup->permissions = \app\core\models\admin\AdminHelper::getFlattenPermissions();

        $adminGroup->save(false);

        $admin = new \app\core\models\admin\Admin();
        $admin->phone = '13012345678';
        $admin->email = 'admin@bp.test';
        $admin->adminGroupId = $adminGroup->id;
        $admin->password = '123456';
        $admin->name = '演示账号';

        $admin->save(false);
    }

    public function safeDown()
    {
        $this->dropTable($this->adminTableName);
        $this->dropTable($this->adminAccessTokenTableName);
        $this->dropTable($this->adminGroupTableName);
        $this->dropTable($this->adminGroupPermissionsTableName);
    }
}
