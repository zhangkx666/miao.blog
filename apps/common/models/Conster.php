<?php

namespace Miao\Common\Models;

/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/9/3
 * Time: 0:14
 */
class Conster
{
    /**
     * 处理：0:新增
     */
    const CREATE = 'create';

    /**
     * 处理：1:查看
     */
    const READ = 'read';

    /**
     * 处理：2:更新
     */
    const UPDATE = 'update';

    /**
     * 处理：3:删除
     */
    const DELETE = 'delete';

    /**
     * ajax return success, use by frontend
     */
    const AJAX_SUCCESS = 1;

    /**
     * ajax return failed, use by frontend
     */
    const AJAX_FAILED = 0;
}