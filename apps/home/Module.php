<?php

namespace Miao\Home;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Miao\Common\VoltFilter;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();
        $loader->registerNamespaces([
            'Miao\Home\Controllers' => APP_PATH . '/home/controllers/',
            'Miao\Home\Models' => APP_PATH . '/home/models/',
            'Miao\Common\Models' => APP_PATH . '/common/models/',
            'Miao\Common' => APP_PATH . '/common/',
            'Miao\Common\Libs' => APP_PATH . '/common/libs'
        ]);
        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        // Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('Miao\Home\Controllers');
            return $dispatcher;
        });

        /**
         * Setting up the view component
         */
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');
            $view->registerEngines([
                '.volt' => function ($view) {
                    $volt = new VoltEngine($view, $this);
                    $volt->setOptions([
                        'compiledPath' => BASE_PATH . '/cache/home/',
                        'compiledSeparator' => '_',
                        'compileAlways' => true
                    ]);
                    // 自定义Filter
                    $voltFilter = new VoltFilter();
                    $voltFilter->setFilter($volt->getCompiler());
                    return $volt;
                },
            ]);
            return $view;
        });
    }
}
