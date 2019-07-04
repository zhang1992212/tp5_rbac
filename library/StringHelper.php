<?php


namespace geek1992\tp5_rbac\library;


/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class StringHelper
{
    /**
     * 密码加密
     * @param string $str
     * @return string
     */
    public static function getPassword(string $str):string
    {
        return md5($str);
    }
}