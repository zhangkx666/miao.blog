<?php
use Phalcon\Mvc\Application;
use Miao\Common\Models\Conster;

error_reporting(E_ALL & ~E_NOTICE);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/apps');

try {
    $start = microtime(true);

    /**
     * Include services
     */
    require BASE_PATH . "/config/services.php";

    /**
     * Handle the request
     */
    $application = new Application();

    /**
     * Assign the DI
     */
    $application->setDI($di);

    /**
     * Include modules
     */
    require BASE_PATH . "/config/modules.php";

    /**
     * Include routes
     */
    require BASE_PATH . '/config/routes.php';

    /**
     * Include common libs
     */
    require BASE_PATH . '/apps/common/libs/CommonFunc.php';

    $application->handle()->send();
    $di->get('logger')->debug('耗时 ' . round(microtime(true) - $start, 3) . ' 秒');
} catch (Exception $e) {
    if ($application->request->isAjax()) {
        $application->response->setJsonContent(['status' => Conster::AJAX_FAILED, 'msg' => utf8_encode($e->getMessage())])->send();
    } else {
        echo $e->getMessage();
    }
    $di->get('logger')->error($e->getMessage());
    $di->get('logger')->error($e->getTraceAsString());
}
