<?php
// phpcs:ignoreFile

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m180621_040655_init_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql' || $this->db->driverName === 'mariadb') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $sql = str_replace('${table-prefix}', $this->getDb()->tablePrefix, file_get_contents(__DIR__ . '/V10001__init_table.sql'));

        $this->getDb()->pdo->exec($sql);

        $adminGroupId = 11;

        \app\core\models\admin\AdminGroupPermission::updatePermissions(
            $adminGroupId,
            \app\core\models\admin\AdminHelper::getFlattenPermissions(),
            []
        );

        /* @var $admin \app\core\models\admin\Admin|null */
        $admin = \app\core\models\admin\Admin::find()->where(['phone' => '13012345678'])->one();

        if ($admin == null) {
            $admin = new \app\core\models\admin\Admin();
            $admin->phone = '13012345678';
            $admin->email = 'dev@agile.test';
            $admin->adminGroupId = $adminGroupId;
            $admin->name = '开发帐号';
        }

        $admin->password = '123456';

        $admin->save(false);

        return true;
    }

    public function safeDown()
    {
    }
}
