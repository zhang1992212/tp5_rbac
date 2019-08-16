<?php

namespace geek1992\tp5_rbac\model;

use geek1992\tp5_rbac\interfaces\BaseModeInterfaces;
use geek1992\tp5_rbac\library\AdministratorLog;
use think\Exception;
use \think\facade\Log;
use think\Model;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
abstract class BaseModel extends Model implements BaseModeInterfaces
{
    protected const NO_WRITE_OPERATE_LOG_MODEL = ['admin_administrator_log', 'admin_login_log'];

    public function insertDataGetId($data)
    {
        $res = $this->insertGetId($data);
        $noWriteLogModel = static::NO_WRITE_OPERATE_LOG_MODEL;
        if ($res && !\in_array($this->name, $noWriteLogModel, true)) {
            AdministratorLog::newLog($res);
        }

        return $res;
    }

    public function insertAllData($data)
    {
        $res = $this->insertAll($data);

        return $res;
    }

    public function updateDataGetInfo($where, $data)
    {
        $data['update_time'] = date('Y-m-d H:i:s');
        $res = $this->where($where)->update($data);
        if ($res) {
            if (\array_key_exists('is_active', $data)) {
                $where['is_active'] = $data['is_active'];
            }
            AdministratorLog::newLog(http_build_query($where));
        }

        return $res;
    }

    public function search(array $condition = [], ?array $order = null, int $start = 1, int $limit = 10, ?array $fields = null): array
    {
        try {
            $query = $this->deleted()->where($condition)->order($order)->field($fields)->limit($start, $limit);
            $list['data'] = $query->select()->toArray();
            $list['total'] = $this->deleted()->where($condition)->count();
        } catch (Exception $e) {
            Log::error($e->getTraceAsString());
            $list = ['data' => [], 'total' => 0];
        }

        return $list;
    }

    public function searchAll(array $condition = [], ?array $order = null, ?array $fields = null): array
    {
        try {
            $query = $this->deleted()->where($condition)->order($order)->field($fields);
            $list['data'] = $query->select()->toArray();
            $list['total'] = $this->deleted()->where($condition)->count();
        } catch (Exception $e) {
            Log::error($e->getTraceAsString());
            $list = ['data' => [], 'total' => 0];
        }

        return $list;
    }

    public function getByCondition(array $condition = [], ?array $order = null, ?array $fields = null): array
    {
        $info = $this->deleted()->where($condition)->field($fields)->order($order)->find();
        if (empty($info)) {
            return [];
        }

        return $info->toArray();
    }

    public function updateDataById(int $id, array $data)
    {
        $data['update_time'] = date('Y-m-d H:i:s');
        $res = $this->updateDataGetInfo(['id' => $id], $data);

        return $res;
    }

    public function getById(int $id, ?array $order = null, ?array $fields = null): array
    {
        return $this->getByCondition(['id' => $id], $order, $fields);
    }

    protected function deleted()
    {
        $this->where(['deleted' => 0]);

        return $this;
    }

}
