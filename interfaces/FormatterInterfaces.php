<?php


namespace geek1992\tp5_rbac\interfaces;


interface FormatterInterface
{
    public function getCode(): int;

    public function format();
}