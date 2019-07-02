<?php

namespace geek1992\tp5_rbac\library;

use geek1992\tp5_rbac\interfaces\FormatterInterface;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Formatter implements FormatterInterface
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
            return Response::create($this->errors, 'json', $this->errors['code']);
        }
        $result['data'] = $this->data;

        return json($result);
    }

    /**
     * 添加返回数据 返回二维数组.
     *
     * @param array $data
     *
     * @return Formatter
     */
    public function addData(array $data = []): self
    {
        if (\count($data) !== \count($data, 1)) {
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
            'detail' => $detail,
        ];

        return $this;
    }

    public function serverError(string $title, string $detail = '', int $status = 500): self
    {
        return $this->setError((int) $status, $title, $detail, (int) $status);
    }

    public function badRequest(string $title, string $detail = '', int $status = 400): self
    {
        return $this->setError((int) $status, $title, $detail, (int) $status);
    }
}
