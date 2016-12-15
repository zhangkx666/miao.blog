<?php

use Miao\Admin\Module as AdminModule;
use Miao\Home\Module as HomeModule;

/**
 * Register application modules
 */
$application->registerModules(
	[
    	'admin' => [
        	'className' => AdminModule::class,
        	'path'      => __DIR__ . '/../apps/admin/Module.php',
    	],
        'home' => [
            'className' => HomeModule::class,
            'path'      => __DIR__ . '/../apps/home/Module.php',
        ]
	]
);
