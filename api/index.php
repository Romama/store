<?php
/**
 * 引导文件
 * 1 设置自动加载器autoloader
 * 2 配置依赖注入DI
 * 3 处理应用请求
 * 4 配置rest/api
 */

error_reporting(E_ALL);
use Phalcon\Events\Manager as EventsManager;
use Phalcon\DI\FactoryDefault,
    Phalcon\Mvc\Micro;

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
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     * 自动加载器
     */
    include APP_PATH . '/config/loader.php';

    // 设置rest/api
    $application = new Micro();

    $application->setDI($di);

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    Logger::localInit("../log/backend.log", FrameWorkConf::LOG_LEVEL);
    Logger::addBasic ( 'logid',Util::genLogId());
    Logger::addBasic('client', $_SERVER['REMOTE_ADDR']);
    // Create a events manager
    $eventManager = new EventsManager();
    // Listen all the application events
    $eventManager->attach('micro', function($event, $application) {
        if ($event->getType() == 'beforeExecuteRoute') {
            return true;

        }
    });

    $application->setEventsManager($eventManager);

    $starTime = microtime(true);

    /**
     * Read rest/api.php
     */
    include APP_PATH . '/rest/api.php';

    Logger::notice('handle request start!method:%s',$_SERVER["REQUEST_URI"]);
    $application->handle();
    //after handle
    $endTime = microtime(true);
    $totalCost = intval ( ($endTime - $starTime) * 1000 );

    //请求耗时
    Logger::notice('handle request end!method:%s total cost:%d(ms)',$_SERVER["REQUEST_URI"],$totalCost);
    Logger::flush();

} catch (PDOException $e){
    Logger::fatal("PDOException %s %s",$e->getMessage(),$e->getTraceAsString());
    echo json_encode($e->getMessage());
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
