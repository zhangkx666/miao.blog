<?php

$router = $di->get("router");

// 分类页
$router->add('/:params', [
    'namespace' => 'Miao\Home\Controllers',
    'module' => 'home',
    'controller' => 'category',
    'action' => 'show',
    'params' => 1
]);
// 首页
$router->add('/', [
    'namespace' => 'Miao\Home\Controllers',
    'module' => 'home',
    'controller' => 'index',
    'action' => 'index'
]);
// 文章页
$router->add('/article/:params', [
    'namespace' => 'Miao\Home\Controllers',
    'module' => 'home',
    'controller' => 'article',
    'action' => 'show',
    'params' => 1
]);
// 文章关联操作
$router->add('/article/:int/:action', [
    'namespace' => 'Miao\Home\Controllers',
    'module' => 'home',
    'controller' => 'article',
    'action' => 2,
    'id' => 1
]);
// 评论
$router->add('/comment/:int/:action', [
    'namespace' => 'Miao\Home\Controllers',
    'module' => 'home',
    'controller' => 'comment',
    'action' => 2,
    'id' => 1
]);
// 瞄一眼
$router->add('/admin', [
    'namespace' => 'Miao\Admin\Controllers',
    'module' => 'admin',
    'controller' => 'index',
    'action' => 'index'
]);



//// 其他路由
//foreach ($application->getModules() as $key => $module) {
//    $namespace = str_replace('Module', 'Controllers', $module["className"]);
//
//    // /admin/category
//    $router->add('/' . $key . '/:controller', [
//        'namespace' => $namespace,
//        'module' => $key,
//        'controller' => 1,
//        'action' => 'index'
//    ])->setName($key);
//
//
//
//
//
////    $router->add('/' . $key . '/:controller/index', [
////        'namespace' => $namespace,
////        'module' => $key,
////        'controller' => 1,
////        'action' => 'index',
////    ]);
////    $router->add('/' . $key . '/:controller/:params', [
////        'namespace' => $namespace,
////        'module' => $key,
////        'controller' => 1,
////        'action' => 'show',
////        'params' => 2
////    ]);
//
//
//}




// /admin/category
$router->add('/admin/:controller', [
    'namespace' => 'Miao\Admin\Controllers',
    'module' => 'admin',
    'controller' => 1,
    'action' => 'index'
]);

// /admin/category/new
$router->add('/admin/:controller/:action', [
    'namespace' => 'Miao\Admin\Controllers',
    'module' => 'admin',
    'controller' => 1,
    'action' => 2,
]);
// /admin/category/1
$router->add('/admin/:controller/:int', [
    'namespace' => 'Miao\Admin\Controllers',
    'module' => 'admin',
    'controller' => 1,
    'action' => 'show',
    'id' => 2
]);

// /admin/category/1/edit
$router->add('/admin/:controller/:int/:action', [
    'namespace' => 'Miao\Admin\Controllers',
    'module' => 'admin',
    'controller' => 1,
    'action' => 3,
    'id' => 2
]);




$di->set("router", $router);
