<?php

namespace Toolkit;
class DebugToolkit
{

    public static function dump($data)
    {
        $string = '<pre>';
        $string .= var_dump($data);
        $string .= '</pre>' . self::eol();
        $string .= self::rowNum();
        return $string;
    }

    public static function log($data)
    {
        $eol = self::eol(1);
        $string = '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . $eol;
        $string .= var_export($data) . $eol;
        $string .= '<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<' . $eol;
        $string .= self::rowNum() . $eol;
        return error_log($string);
    }

    //返回整数的二进制表示
    public static function dumpBinary($integer)
    {
        return "{$integer}:" . decbin($integer);
    }

    //返回函数或者类方法定义的位置
    public static function dumpFunc($funcName)
    {
        try {
            if (is_array($funcName)) {
                $func = new ReflectionMethod($funcName[0], $funcName[1]);
                $funcName = $funcName[1];
            } else {
                $func = new ReflectionFunction($funcName);
            }
        } catch (ReflectionException $e) {
            echo $e->getMessage();
            return;
        }
        $start = $func->getStartLine() - 1;
        $end = $func->getEndLine() - 1;
        $filename = $func->getFileName();
        return "$funcName 定义位置: $filename($start - $end)";
    }

    //返回当前行号
    public static function rowNum()
    {
        $debugInfo = debug_backtrace();
        return "当前位置:{$debugInfo[0]['file']}的{$debugInfo[0]['line']}行";
    }

    //返回换行符TODO:isLog
    public static function eol($isLog = 0)
    {
        if ($isLog) {
            return PHP_EOL;
        }
        return ('cli' == php_sapi_name()) ? PHP_EOL : '<br/>';
    }
}
