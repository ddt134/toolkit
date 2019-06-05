<?php
namespace Toolkit;
class ArrayToolkit{
    /*
     *返回去除重复值之后的一维数组或者二维数组
     * */
    public static function distinct($array)
    {
        return array_unique($array, SORT_REGULAR);
    }

    /*
     * 二维数组根据$condition的值进行过滤
     * */
    public static function filterByCondition($array, $condition)
    {
        return array_filter($array, function ($value) use ($condition) {
            $flag = true;
            foreach ($condition as $k => $v) {
                if (!isset($value[$k])) {
                    $flag = false;
                }
                if (is_array($v)) {
                    if (!in_array($value[$k], $v)) {
                        $flag = false;
                    }
                } else {
                    if ($value[$k] != $v) {
                        $flag = false;
                    }
                }
            }

            return $flag;
        });
    }

    /*
     * 把$columns合并到二维数组中
     * */
    public static function mergeColumns($array, $columns)
    {
        return array_map(function ($value) use ($columns) {
            return array_merge($value, $columns);
        }, $array);
    }

    /*
     * 根据一维数组$keys的值$key,生成以$key为键,$columns为每一行内容的二维数组
     * */
    public static function setDefaultValue($keys, $columns)
    {
        $arr = array();
        foreach ($keys as $key) {
            $arr[$key] = $columns;
        }

        return $arr;
    }
}