<?php

namespace Miao\Home\Controllers;

use Miao\Common\Models\Category;
use Miao\Common\Models\Article;
use Phalcon\Mvc\View;

class CategoryController extends BaseController
{

    public function indexAction()
    {
        $this->view->categories = Category::find(['parent_id is null', 'order' => 'sort asc']);
    }

    /**
     * 分类展示页
     */
    public function showAction()
    {
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $cat_name = $this->getParam(0);
        $cat = Category::findFirst(["name = :name:", "bind" => ["name" => $cat_name]]);

        // 如果是子类，父类的名称
        if ($cat->parent_id)
            $cat_name = $cat->parent->name;
        $this->view->category_name = $cat_name;
        $this->view->articles = Article::find(["deleted_at is null and category_id = {$cat->id}", 'limit' => 15, 'order' => 'id desc']);
    }
}

