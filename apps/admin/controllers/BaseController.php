<?php
namespace Miao\Admin\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\View;
use Miao\Common\Models\Conster;

/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/9/13
 * Time: 11:02
 */
class BaseController extends Controller
{
    /**
     * initialize function
     */
    public function initialize()
    {
        // no cache
        $this->response->setCache(0);

        // breadcrumbs
        $controller_name = $this->lang->_('menu.' . $this->dispatcher->getControllerName());
        $action_name = $this->lang->_($this->dispatcher->getControllerName() . '/' . $this->dispatcher->getActionName());
        $this->view->controller_name = $controller_name;
        $this->view->action_name = $action_name;

        // page title
        $title = empty($action_name) ? $controller_name : $action_name . ' - ' . $controller_name;
        $this->tag->setTitle($title . ' - ' . $this->config->project->name);

        // flash 显示时间 null
        $this->view->flash_time = null;

        // 打印参数
//        $this->logger->info('---------------------------------------------------------------------------------------------'); // TODO delete
//        $this->logger->info(json_encode($this->request->getUserAgent()));
//        $this->logger->info(json_encode($this->request->getURI()));
//        $this->logger->info(json_encode($this->dispatcher->getParams()));
//        if ($this->request->isPost()) $this->logger->info(json_encode($_POST)); // TODO delete
//        if ($this->request->isGet()) $this->logger->info(json_encode($_GET)); // TODO delete
    }

    /**
     * use layouts/blank
     */
    protected function useBlankTpl()
    {
        $this->view->setTemplateAfter('blank')->setRenderLevel(View::LEVEL_AFTER_TEMPLATE);
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
//            $this->logger->debug($msg); // TODO delete
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

//    protected function sendFailedMsg($handle, $model, $data = null)
//    {
//        $handle = [Model::OP_CREATE => 'create', Model::OP_UPDATE => 'update', Model::OP_DELETE => 'delete'][$handle];
//        $msg = $this->lang->_("handle.$handle.failed") .
//            '<br><span class="color-danger">' . implode('<br>', $model->getMessages()) . '</span>';
//        $return = ['status' => Conster::AJAX_FAILED, 'msg' => $msg];
//        if (isset($data)) $return['data'] = $data;
//        $this->renderJson($return);
//    }

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
}
