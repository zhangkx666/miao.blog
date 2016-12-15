<?php

/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/9/13
 * Time: 11:02
 */
namespace Miao\Home\Controllers;

use Miao\Common\Models\Article;
use Phalcon\Mvc\View;

class IndexController extends BaseController
{
    /**
     * website index page
     */
    public function indexAction()
    {
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $this->view->articles = Article::find(['deleted_at is null', 'limit' => 15, 'order' => 'id desc']);
        $this->view->category_name = 'index';
    }
}