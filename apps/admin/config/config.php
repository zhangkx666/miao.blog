<?php
/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/9/13
 * Time: 11:26
 */

use Phalcon\Config;

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../../..'));

return new Config([]);