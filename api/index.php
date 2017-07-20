<?php
/**
 * 引导文件
 * 1 设置自动加载器autoloader
 * 2 配置依赖注入DI
 * 3 处理应用请求
 */
use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     * 注册一个自动加载器
     */
    $di = new FactoryDefault();

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Read api.php
     */
    include APP_PATH . '/script/api.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     * 自动加载器
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo str_replace(["\n","\r","\t"], '', $application->handle()->getContent());

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
