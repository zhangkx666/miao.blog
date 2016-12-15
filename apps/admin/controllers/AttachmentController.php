<?php
namespace Miao\Admin\Controllers;
use Miao\Common\Libs\Markdown;
use Miao\Common\Models\Article;
use Miao\Common\Models\Category;
use Miao\Common\Models\Conster;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model;

/**
 * Created by PhpStorm.
 * User: zhangkx
 * Date: 2016/9/13
 * Time: 11:02
 */
class AttachmentController extends BaseController
{
    /**
     * upload image file
     */
    public function uploadImageAction()
    {
        if (!$this->request->hasFiles()) {
            $this->renderJson(['status' => Conster::AJAX_FAILED, 'msg' => '没有上传文件']);
            return;
        }
        try {
            $file = $this->request->getUploadedFiles()[0];
            if ($file->getSize() == 0) {
                $this->renderJson([
                    'status' => Conster::AJAX_FAILED,
                    'msg' => '文件上传出错，当前最大允许上传 ' . ini_get('upload_max_filesize')
                ]);
                return;
            }

            $ext = strtolower(pathinfo($file->getName(), PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'gif', 'png'])) {
                $this->renderJson([
                    'status' => Conster::AJAX_FAILED,
                    'msg' => '仅允许上传 jpg、gif、png'
                ]);
                return;
            }

            // 生成8位的文件
            $save_file_name = substr(md5_file($file->getTempName()), 8, 16) . '.' . $ext;
            $file->moveTo($this->config->upload_path . $save_file_name);
            $this->renderJson(['status' => Conster::AJAX_SUCCESS, 'src' => '/images/' . $save_file_name]);
        } catch (\Exception $e) {
            $this->renderJson(['status' => Conster::AJAX_FAILED, 'msg' => $e->getMessage(), 'e' => $e->getTrace()]);
        }
    }
}

