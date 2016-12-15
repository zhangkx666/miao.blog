<?php

namespace Miao\Admin;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Translate\Adapter\NativeArray as Lang;
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
            'Miao\Admin\Controllers' => APP_PATH . '/admin/controllers/',
            'Miao\Admin\Models' => APP_PATH . '/admin/models/',
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
            $dispatcher->setDefaultNamespace('Miao\Admin\Controllers');
            return $dispatcher;
        });

        /**
         * Setting up the view component
         */
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir(APP_PATH . '/admin/views/');
            $view->registerEngines([
                '.volt' => function ($view) {
                    $volt = new VoltEngine($view, $this);
                    $volt->setOptions([
                        'compiledPath' => BASE_PATH . '/cache/admin/',
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

        // 语言文件
        $di->set('lang', function () use ($di) {
            $language = include APP_PATH . '/admin/lang/' . $di->get('config')->project->lang . '.php';
            return new Lang(['content' => $language]);
        });
    }
}
