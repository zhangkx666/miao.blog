<?php
namespace Miao\Admin\Controllers;
use Miao\Common\Libs\Markdown;
use Miao\Common\Models\Article;
use Miao\Common\Models\Category;
use Miao\Common\Models\Conster;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model;
use HyperDown;

/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/9/13
 * Time: 11:02
 */
class ArticleController extends BaseController
{
    /**
     * articles
     */
    public function indexAction()
    {
        // 当前页
        $page = empty($_GET['page']) ? 1 : $_GET['page'];

        // 分页设置
        $pager = $this->config->pager;

        // limit
        $limit = isset($pager->limit) ? $pager->limit : 15;
        $offset = $limit * ($page - 1);

        // 总记录数
        $total_count = Article::count('deleted_at is null');

        // 总页数
        $this->view->total_page = ceil($total_count / $pager->limit);

        // 根据分页查询记录
        $this->view->articles = Article::find(['deleted_at is null', 'order' => 'id desc', 'limit' => $limit, 'offset' => $offset]);
    }

    /**
     * new article page
     * /admin/article/new
     */
    public function newAction()
    {
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $this->view->article = new Article();
        $this->view->categories = $this->getCategories();
    }

    /**
     * edit article page
     */
    public function editAction()
    {
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $this->view->article = Article::findFirst('id=' . $this->getParam('id'), false);
        $this->view->categories = $this->getCategories();
    }

    /**
     * /admin/article/create
     */
    public function createAction()
    {
        // checkbox fields
        $data = $this->request->getPost();
        $data['is_show'] = isset($data['is_show']);
        $data['user_id'] = 1;
        $data['markdown'] = $data['markdown_content']; // markdown content
        $data['html'] = (new Markdown())->makeHtml($data['markdown']);

        $category = new Article();
        $success = $category->save($data, $category->insert_fields);

        $this->sendHandleResult(Model::OP_CREATE, $category, $success, ['url' => "/article/{$category->id}"]);
    }

    /**
     * /admin/article/create
     */
    public function updateAction()
    {
        // checkbox fields
        $data = $this->request->getPost();
        $data['is_show'] = isset($data['is_show']);
        $data['markdown'] = $data['markdown_content'];
        $data['html'] = (new Markdown())->makeHtml($data['markdown']);

        $article = Article::findFirst("id = {$this->getParam('id')}");
        $success = $article->save($data, $article->update_fields);
        $this->sendHandleResult(Model::OP_UPDATE, $article, $success, ['url' => "/article/{$article->id}"]);
    }

    /**
     * delete category
     */
    public function deleteAction()
    {
        $article = Article::findFirst("id = {$this->getParam('id')}");
//        $success = $article->delete();
        $success = true;
        $this->sendHandleResult(Model::OP_DELETE, $article, $success);
    }

    /**
     * 获取分类
     * @return array
     */
    private function getCategories()
    {
        // 分类
        $cats = [];
        $categories = Category::find(['parent_id is null', 'order' => 'sort asc']);
        foreach ($categories as $cat) {
            $cats[] = $cat;
            foreach ($cat->children as $child) {
                $child->title = '　　- ' . $child->title;
                $cats[] =  $child;
            }
        }
        return $cats;
    }
}

