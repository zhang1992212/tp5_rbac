<?php

namespace geek1992\tp5_rbac\library;

use think\facade\Request;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class LoginLog
{
    public static function newLog(string $relationId, int $type = 0)
    {
        $request = Request::instance();
        $attribute = [
            'admin_id' => (int) $request->admin['id'],
            'ip' => (string) $request->ip(),
            'agent' => (string) $request->header('user-agent'),
            'action' => $request->uniqueId,
            'relation' => json_encode($relationId),
            'type' => $type,
        ];

        $model = new \geek1992\tp5_rbac\model\LoginLog();

        $model->insertDataGetId($attribute);
    }
}
