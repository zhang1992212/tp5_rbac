<?php

namespace geek1992\tp5_rbac\library;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class ArrayHelper
{
    /**
     * 删除数组指定的key对应的值
     *
     *  $a = [a=>1, b=>2, c=>3]
     *  $b = [a, b]
     *  ArrayHelper::array_filter_fields($a, $b) ==> [a=>1, b=>2]
     *
     *  $a = [ [a=>1, b=>2, c=>3], [a=>1, b=>2, c=>3],[a=>1, b=>2, c=>3]]
     *  $b = [a, b]
     *  ArrayHelper::array_filter_fields($a, $b) ==> [[a=>1, b=>2], [a=>1, b=>2], [a=>1, b=>2]]
     *
     * @param array $data
     * @param array|null $fields
     * @return array
     */
    public static function array_filter_fields(array $data, ?array $fields = null)
    {
        if (empty($data) || null === $fields) {
            return $data;
        }
        $new = [];
        if (\count($data) !== \count($data, 1)) {//二维数组
            foreach ($data as $key => $item) {
                $new[$key] = static::array_filter_fields_item($item, $fields);
            }
        } else {
            $new = static::array_filter_fields_item($data, $fields);
        }

        return $new;
    }

    private static function array_filter_fields_item(array $data, array $fields)
    {
        $new = [];
        foreach ($data as $key => $item) {
            if (\in_array($key, $fields, true)) {
                $new[$key] = $item;
            }
        }

        return $new;
    }
}
