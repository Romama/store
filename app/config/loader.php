<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->testsDir,
        $config->application->restDir,
        $config->application->logicDir,
        $config->application->libraryDir,
        $config->application->configDir,
    ]
)->register();
