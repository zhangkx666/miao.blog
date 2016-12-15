<?php
/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/12/13
 * Time: 19:02
 */


/**
 * 格式化日期为 3分钟前， 10天前
 * @param $time 2016-12-12 12:12
 * @param string $format format
 * @return false|null|string 3分钟前
 */
function from_time($time, $format = 'm-d')
{
    $away = time() - $time;
    $result = null;
    if ($away < 60) {
        $result = '刚刚';
    } elseif ($away >= 60 && $away < 3600) {
        $result = floor($away / 60) . '分钟前';
    } elseif ($away >= 3600 && $away < 86400) {
        $result = floor($away / 3600) . '小时前';
    } elseif ($away >= 86400 && $away < 2592000) {
        $result = floor($away / 86400) . '天前';
    } elseif ($away >= 2592000 && $away < 15552000) {
        $result = floor($away / 2592000) . '个月前';
    } else {
        $result = date($format, $time);
    }
    return $result;
}
