<?php
/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/9/13
 * Time: 11:26
 */

use Phalcon\Config;
use Phalcon\Config\Adapter\Ini as ConfigIni;

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));

$config = new Config(
    [
        // log file path
        'log_path' =>  BASE_PATH . '/logs/miao_' . date('Y_m_d') . '.log',

        // upload path
        'upload_path' => BASE_PATH . '/images/',

        // if true, then we print a new line at the end of each CLI execution
        'printNewLine' => true,
    ]
);
return $config->merge(new ConfigIni("config.ini"));
