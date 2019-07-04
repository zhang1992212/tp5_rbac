<?php

namespace geek1992\tp5_rbac\command\migration;

use Phinx\Db\Adapter\AdapterFactory;
use Phinx\Migration\MigrationInterface;
use think\migration\command\Migrate;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class RbacMigrate extends Migrate
{


    public function getAdapter()
    {
        if (isset($this->adapter)) {
            return $this->adapter;
        }

        $options = $this->getDbConfig();
        $options['default_migration_table'] = $options['table_prefix'] . 'rbac_migrations';

        $adapter = AdapterFactory::instance()->getAdapter($options['adapter'], $options);

        if ($adapter->hasOption('table_prefix') || $adapter->hasOption('table_suffix')) {
            $adapter = AdapterFactory::instance()->getWrapper('prefix', $adapter);
        }

        $this->adapter = $adapter;

        return $adapter;
    }
}
