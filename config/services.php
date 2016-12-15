<?php

/**
 * Services are globally registered in this file
 */

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Cache\Frontend\Data as FrontendData;
use Phalcon\Cache\Backend\Memcache as BackendMemcached;
//use Phalcon\Cache\Backend\Libmemcached  as BackendMemcached; # 服务器上用这个
use Phalcon\Flash\Session as Flash;

/**
 * Read configuration
 */
$config = include BASE_PATH . '/config/config.php';

/**
 * The FactoryDefault Dependency Injector automatically registers the right
 * services to provide a full stack framework.
 */
$di = new FactoryDefault();

/**
 * Shared configuration service
 */
$di->setShared('config', $config);

/**
 * Registering a router
 */
$di->setShared('router', function () {
    $router = new Router();
    $router->setDefaultModule('home');
    $router->setDefaultNamespace('Miao\Home\Controllers');
    return $router;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $url = new UrlResolver();
    $url->setBaseUri('/miao/');
    return $url;
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * logger
 */
$di->set('logger', function() use ($config) {
    return new FileAdapter($config->log_path);
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () use ($di, $config) {
    $dbConfig = $config->database->toArray();
    $dbAdapter = '\Phalcon\Db\Adapter\Pdo\\' . $dbConfig['adapter'];
    $connection =  new $dbAdapter($dbConfig);

    // 打印sql日志
    $eventsManager = new EventsManager();
    $logger = $di->get('logger');

    // 监听所有数据库事件
    $eventsManager->attach('db', function ($event, $connection) use ($logger) {
        if ($event->getType() == 'beforeQuery') {
            $logger->info($connection->getSQLStatement());
        }
    });

    // 设置事件管理器
    $connection->setEventsManager($eventsManager);

    return $connection;
});

// 设置模型缓存服务
$di->setShared('modelsCache', function () use ($config) {

    // 默认缓存时间为一天
    $frontCache = new FrontendData(["lifetime" => $config->cache->lifetime]);

    // Memcached连接配置 这里使用的是Memcache适配器
    $cache = new BackendMemcached(
        $frontCache,
        [
            "host" => $config->cache->host,
            "port" => $config->cache->port
        ]
    );
    return $cache;
});