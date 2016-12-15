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

class ArticleController extends BaseController
{
    /**
     * articles
     */
    public function indexAction()
    {

    }

    /**
     * 显示文章
     * @param $id article.id or article.name
     */
    public function showAction($id)
    {
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);

        // 文章明细
        $condition = is_numeric($id) ? "id = $id" : ["link = :link:", "bind" => ["link" => $id]];
        $article = Article::findFirst($condition, true);
        if ($article) {
            $this->view->article = $article;

            // 分类
            $category = $article->category;
            if ($category)
                $this->view->category_name = empty($category->parent_id) ? $category->name : $category->parent->name;
            $this->db->query("UPDATE article SET view_count = view_count + 1 WHERE id = " . $article->id);  // 阅读次数+1

            // 评论
            $this->view->comments = Comment::find("article_id = " . $article->id);
        } else {
            $this->view->article = new Article();
        }
    }

    /**
     * 创建评论
     */
    public function commentAction()
    {
        $article_id = $this->getParam('id');

        // 判断验证问题 TODO 跟数据库设置值对比. 先暂时这样
        if ($_POST['captcha'] != '10') {
            $this->renderJson(['status' => 0, 'msg' => '验证问题不正确！']);
            return;
        }

        // 获取并存储数据(包含自动验证)
        $data = $this->request->getPost();
        $data['article_id'] = $article_id;
        $data['markdown'] = $data['markdown_content'];
        $data['html'] = (new Markdown())->makeHtml($data['markdown']);
        $data['avatar'] = $this->get_gravatar($data['email']);
        $comment = new Comment();
        $success = $comment->save($data);

        if ($success === true) {
            $return = [
                'status' => Conster::AJAX_SUCCESS,
                'msg' => '提交成功',
                'id' => $comment->id,
                'avatar' => $comment->avatar
            ];
            $this->db->query("UPDATE article SET comment_count = comment_count + 1 WHERE id = " . $article_id);  // 评论次数+1
            $this->renderJson($return);
        } else {
            $msg = '评论提交失败' . '<br><span class="color-danger">' . implode('<br>', $comment->getMessages()) . '</span>';
            $this->renderJson(['status' => Conster::AJAX_FAILED, 'msg' => $msg]);
        }
    }

    /**
     * 点赞次数+1
     */
    public function likeAction()
    {
        $this->db->query("UPDATE article SET like_count = like_count + 1 WHERE id = " . $this->getParam('id'));
        $this->renderJson(['status' => Conster::AJAX_SUCCESS]);
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param int $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @return String containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */
    private function get_gravatar($email, $s = 64)
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s";
        return $url;
    }
}