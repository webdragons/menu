<?php

namespace bulldozer\menu\console\migrations;

use bulldozer\App;
use bulldozer\users\rbac\DbManager;
use yii\base\InvalidConfigException;
use yii\db\Migration;

/**
 * Class m180216_213541_init_tables
 */
class m180216_213541_init_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'levels' => $this->smallInteger(2)->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%menu_links}}', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer(11)->unsigned()->notNull(),
            'active' => $this->boolean()->defaultValue(1),
            'parent_id' => $this->integer(11)->unsigned()->notNull(),
            'level' => $this->smallInteger(2)->unsigned()->notNull()->defaultValue(1),
            'sort' => $this->integer(11)->unsigned()->defaultValue(100),
            'label' => $this->string(255)->notNull(),
            'url' => $this->string(500)->notNull(),
        ], $tableOptions);

        $authManager = $this->getAuthManager();

        $permission = $authManager->createPermission('menu_manage');
        $permission->name = 'Управление меню';
        $authManager->add($permission);

        $admin = $authManager->getRole('admin');
        $authManager->addChild($admin, $permission);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu}}');

        $authManager = $this->getAuthManager();

        $managePages = $authManager->getPermission('menu_manage');
        $authManager->remove($managePages);
    }

    /**
     * @throws InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = App::$app->getAuthManager();

        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }
}
