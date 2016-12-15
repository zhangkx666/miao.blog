<?php
/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/9/3
 * Time: 10:22
 */
namespace Miao\Common\Models;

use Phalcon\Mvc\Model\Behavior\SoftDelete;

trait LogicDelete
{
    public function initialize()
    {
        // logic delete
        $this->addBehavior(new SoftDelete(
            array(
                'field' => 'deleted_at',
                'value' => date('Y-m-d H:i:s')
            )
        ));
    }
}