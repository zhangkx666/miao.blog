<?php

namespace Miao\Admin\Controllers;

use Miao\Common\Libs\DingTalk;
use Miao\Common\Models\Conster;

class DingController extends BaseController
{

    public function indexAction()
    {

    }

    public function sendMsgAction() {
       try {
           $ding = new DingTalk();
           $result = $ding->sendText("manager5182", $_GET['msg']);
           $this->logger->debug(json_encode($result));
       } catch (Exception $e) {
           $this->logger->debug($e->getMessage());
       }

        $this->view->disable();
        $this->response->setHeader("Content-Type", "text/html");
        $this->response->setHeader("Charset", "utf-8");
        echo $_GET['callback'] . "(".json_encode(['status' => Conster::AJAX_SUCCESS, 'msg' => 'send success']).")";
    }
}
