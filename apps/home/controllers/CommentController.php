<?php

/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/9/13
 * Time: 11:02
 */
namespace Miao\Home\Controllers;

use Miao\Common\Libs\Markdown;
use Miao\Common\Models\Article;
use Miao\Common\Models\Comment;
use Miao\Common\Models\Conster;
use Phalcon\Mvc\View;

class CommentController extends BaseController
{
    /**
     * 点赞次数+1
     */
    public function likeAction()
    {
        // 点赞次数+1
        $this->db->query("UPDATE comment SET like_count = like_count + 1 WHERE id = " . $this->getParam('id'));
        $this->renderJson(['status' => Conster::AJAX_SUCCESS]);
    }
}