<?php

/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf\Bootstrap_Abstract
{

    /**
     * 初始化 Vendor
     * @param \Yaf\Dispatcher $dispatcher
     */
    public function _initVendor(Yaf\Dispatcher $dispatcher)
    {
        define('APP_NAME', 'lmz-demo');
        require(APP_PATH . '/Vendor/Bootstrap/Autoloader.php');
        \Bootstrap\Autoloader::instance()->addRoot(APP_PATH . '/')->init();
    }

    /**
     * 初始化 yaf config
     * @param \Yaf\Dispatcher $dispatcher
     */
    public function _initConfig(Yaf\Dispatcher $dispatcher)
    {
        $app = (array)new \Config\App();
        $config = Yaf\Application::app()->getConfig();
        $config = new Yaf\Config\Simple($config->toArray(), false);
        foreach ($app as $key => $val) {
            $config->set($key, $val);
        }
        Yaf\Registry::set("config", $config);
        $router = $dispatcher::getInstance()->getRouter();
        $router->addConfig(Yaf\Registry::get("config")->routes);
    }

    /**
     * 加载插件
     * @param \Yaf\Dispatcher $dispatcher
     */
    public function _initPlugin(Yaf\Dispatcher $dispatcher)
    {
        $dispatcher->registerPlugin(new TplPlugin());
    }

}
