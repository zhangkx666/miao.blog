<?php
//
//                    _ooOoo_
//                   o8888888o
//                   88" . "88
//                   (| -_- |)
//                   O\  =  /O
//                ____/`---'\____
//              .'  \\|     |//  `.
//             /  \\|||  :  |||//  \
//            /  _||||| -:- |||||-  \
//            |   | \\\  -  /// |   |
//            | \_|  ''\---/''  |   |
//            \  .-\__  `-`  ___/-. /
//          ___`. .'  /--.--\  `. . __
//       ."" '<  `.___\_<|>_/___.'  >'"".
//      | | :  `- \`.;`\ _ /`;.`/ - ` : | |
//      \  \ `-.   \_ __\ /__ _/   .-` /  /
// ======`-.____`-.___\_____/___.-`____.-'======
//                    `=---='
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//             佛祖保佑       永无BUG

namespace Miao\Admin\Controllers;

use Miao\Common\Models\Category;
use Phalcon\Mvc\Model;

/**
 * User: Robbie
 * Date: 2016/11/22
 */
class CategoryController extends BaseController
{
    /**
     * index page
     */
    public function indexAction()
    {
        $this->view->categories = Category::find(['parent_id is null', 'order' => 'sort asc']);
    }

    public function showAction()
    {
        $this->view->id = $this->getParam('id');
    }

    /**
     * add category page
     */
    public function newAction()
    {
        $this->useBlankTpl();
        $this->view->category = new Category();
        $this->view->parent_categories = Category::find(['parent_id is null', 'order' => 'sort asc']);
    }

    /**
     * create category
     * ajax return
     */
    public function createAction()
    {
        // checkbox fields
        $data = $this->request->getPost();
        $data['is_show'] = isset($data['is_show']);
        $data['show_in_nav'] = isset($data['show_in_nav']);

        $category = new Category();
        $success = $category->save($data, $category->insert_fields);
        $this->sendHandleResult(Model::OP_CREATE, $category, $success);
    }

    /**
     * edit category page
     */
    public function editAction()
    {
        $this->useBlankTpl();
        $this->view->parent_categories = Category::find(['parent_id is null', 'order' => 'sort asc']);
        $this->view->category = Category::findFirst(["id = {$this->getParam('id')}"]);
    }

    /**
     * update category
     */
    public function updateAction()
    {
        // checkbox fields
        $data = $this->request->getPost();
        $data['is_show'] = isset($data['is_show']);
        $data['show_in_nav'] = isset($data['show_in_nav']);

        $category = Category::findFirst("id = {$this->getParam('id')}");
        $success = $category->save($data, $category->update_fields);
        $this->sendHandleResult(Model::OP_UPDATE, $category, $success);
    }

    /**
     * delete category
     */
    public function deleteAction()
    {
        $category = Category::findFirst("id = {$this->getParam('id')}");
//        $success = $category->delete();
        $success  = true;
        $this->sendHandleResult(Model::OP_DELETE, $category, $success);
    }
}
