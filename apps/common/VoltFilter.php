<?php
/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/9/22
 * Time: 1:01
 */

namespace Miao\Common;

class VoltFilter
{
    function setFilter(&$compiler)
    {
        // 格式化日期 需要传format参数, 不传参数则为 'Y-m-d H:i'
        $compiler->addFilter('date_format', function ($args) {
            $args = explode(', ', $args);
            if (count($args) == 1)
                $args[] = "'Y-m-d H:i'";
            return "date($args[1], strtotime($args[0]))";
        });

        // 格式化日期为 3分钟前， 10天前
        $compiler->addFilter('from_now', function ($args) {
            return "from_time(strtotime($args))";
        });

        // 四舍五入
        $compiler->addFilter('round', function ($args) {
            $args = explode(', ', $args);
            return "round($args[0], $args[1])";
        });

        // array_keys
        $compiler->addFilter('array_keys', function ($args) {
            return "array_keys($args)";
        });
        
        // count
        $compiler->addFilter('count', function ($args) {
            return "count($args)";
        });
    }
}

