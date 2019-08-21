<?php

namespace geek1992\tp5_rbac\library;

use geek1992\tp5_rbac\interfaces\FormatterInterfaces;
use think\facade\Request;
use think\Response;
use think\response\Json;

/**
 * 格式化返回api数据
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Formatter implements FormatterInterfaces
{

    protected $code = '200';

    protected $data = [];

    protected $msg = '';

    protected $errors = [];

    /**
     * @return Formatter
     */
    public static function newInstance(): self
    {
        return new static();
    }

    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return Json
     */
    public function format(): Json
    {
        if (!empty($this->errors)) {
            return Request::create($this->errors, 'json', $this->errors['code']);
        }
        $result['data'] = $this->data;
        return json($result);
    }

    public function addData(array $data = []): self
    {
        if (count($data) !== count($data, 1)) {
            $this->data = $data;
        } else {
            $this->data[] = $data;
        }
        return $this;
    }

    public function setError(int $status, string $title = '', string $detail = '', int $code = 0): self
    {
        $this->code = $status;
        $this->errors = [
            'code' => $code ?: $status,
            'title' => $title,
            'detail' => $detail
        ];
        return $this;
    }

    public function serverError(string $title, int $status =500,string $detail = ''): self
    {
        return $this->setError((int)$status, $title, $detail, (int)$status);
    }

    public function badRequest(string $title,int $status = 400, string $detail = ''): self
    {
        return $this->setError((int)$status, $title, $detail, (int)$status);
    }
}