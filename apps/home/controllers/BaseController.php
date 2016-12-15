<?php
/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/9/13
 * Time: 11:02
 */
namespace Miao\Home\Controllers;

use Phalcon\Mvc\Controller;
use Miao\Common\Models\Category;
use Phalcon\Mvc\Model;
use Miao\Common\Models\Conster;


class BaseController extends Controller
{
    function initialize() {
        // 目录分类
        $this->view->nav_categories = Category::find('deleted_at is null and parent_id is null and show_in_nav = 1', true);
    }

    /**
     * render json
     * @param $content array content
     */
    protected function renderJson($content)
    {
        $this->view->disable();
        echo $this->response->setJsonContent($content)->getContent();
    }

    /**
     * Gets a param by its name
     * @param $param
     * @param null $filters
     * @param null $defaultValue
     * @return mixed
     */
    protected function getParam($param, $filters = null, $defaultValue = null)
    {
        return $this->dispatcher->getParam($param, $filters, $defaultValue);
    }

    /**
     * @param $handle integer handle
     * @param $model Model handle model
     * @param $success bool is handle success
     * @param $data array
     */
    protected function sendHandleResult($handle, $model, $success, $data = null)
    {
        // handle type, used by message lang
        $handle = [Model::OP_CREATE => 'create', Model::OP_UPDATE => 'update', Model::OP_DELETE => 'delete'][$handle];

        // handle failed
        if ($success === false) {
            $msg = $this->lang->_("handle.$handle.failed") .
                '<br><span class="color-danger">' . implode('<br>', $model->getMessages()) . '</span>';
            $return = ['status' => Conster::AJAX_FAILED, 'msg' => $msg];
            if (isset($data)) $return['data'] = $data;
            $this->renderJson($return);
        } else {
            $return = ['status' => Conster::AJAX_SUCCESS, 'msg' => $this->lang->_("handle.$handle.success")];
            if (isset($data)) {
                if (isset($data['url'])) {
                    $return['url'] = $data['url'];
                    unset($data['url']);
                }
                $return['data'] = $data;
            }

            $this->renderJson($return);
        }
    }
}
