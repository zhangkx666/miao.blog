<?php

namespace Miao\Admin\Controllers;

use Miao\Common\Libs\Markdown;
use Miao\Common\Models\Article;
use Phalcon\Mvc\View;

class TagController extends BaseController
{

    public function indexAction()
    {
//        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
//        $aticle = Article::findFirst("id=28");
//        $this->view->markdown = (new Markdown())->makeHtml($aticle->markdown);


//        $acmation = array(
//            array('xid' => 4, 'inid' => 2),
//            array('xid' => 5, 'inid' => 2),
//            array(
//                'xid' => 7,
//                'inid' => 2,
//                'ylibrary' => array(
//                    array(
//                        'yquantity' => 100,
//                        'nquantity' => 0,
//                        'lstquantity' => 600
//                    ),
//                    array(
//                        'yquantity' => 200,
//                        'nquantity' => 0,
//                        'lstquantity' => 800
//                    ),
//                    array(
//                        'yquantity' => 100,
//                        'nquantity' => 0,
//                        'lstquantity' => 700
//                    ),
//                    array(
//                        'yquantity' => 100,
//                        'nquantity' => 0,
//                        'lstquantity' => 30
//                    ),
//                    array(
//                        'yquantity' => 100,
//                        'nquantity' => 0,
//                        'lstquantity' => 100
//                    )
//                )
//            )
//        );
//
//        foreach ($acmation as &$item) {
//            if ($item['ylibrary']) {
//                foreach ($item['ylibrary'] as $key => $row) {
//                    $lstquantity[$key] = $row ['lstquantity'];
//                }
//                array_multisort($lstquantity, SORT_DESC, SORT_NUMERIC, $item['ylibrary']);
//            }
//        }
//
//        $this->renderJson($acmation);
    }

    public function index()
    {
        $notices = [];
        foreach ([1, 3, 4, 5] as $type) {
            $notices["type$type"] = M('Notice')->where("type = $type")->order('id desc')->limit(5)->select();
        }

        $news = [];
        foreach ([1, 2] as $type) {
            $news["type$type"] = M('News')->where("type = $type")->order('id desc')->limit(5)->select();
        }

        $this->assign('notices', $notices);
        $this->assign('news', $news);
    }
}

