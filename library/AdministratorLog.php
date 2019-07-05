<?php

namespace geek1992\tp5_rbac\library;

use think\Request;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class AdministratorLog
{
    public static function newLog(string $relationId)
    {
        $request = Request::instance();
        $attribute = [
            'admin_id' => (int) $request->admin['id'],
            'ip' => (string) $request->ip(),
            'agent' => (string) $request->header('user-agent'),
            'action' => $request->uniqueId,
            'relation' => json_encode($relationId),
        ];

        $model = new \geek1992\tp5_rbac\model\AdministratorLog();

        $model->insertData($attribute);
    }
}
