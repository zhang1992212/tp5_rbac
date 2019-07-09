<?php

namespace geek1992\tp5_rbac\interfaces;

use think\response\Json;

interface FormatterInterfaces
{
    public function getCode(): int;

    public function format():Json;
}
