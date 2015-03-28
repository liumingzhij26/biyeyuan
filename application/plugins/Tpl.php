<?php
use Yaf\Plugin_Abstract;
use Yaf\Request_Abstract;
use Yaf\Response_Abstract;
use Yaf\Registry;
use Yaf\Dispatcher;

class TplPlugin extends Plugin_Abstract
{

    /**
     * 在路由之前触发
     *
     * @param Request_Abstract $request
     * @param Response_Abstract $response
     * @return mixed|void
     */
    public function routerStartup(Request_Abstract $request, Response_Abstract $response)
    {

    }

    /**
     * 路由结束之后触发       此时路由一定正确完成, 否则这个事件不会触发
     *
     * @param Request_Abstract $request
     * @param Response_Abstract $response
     * @return mixed|void
     */
    public function routerShutdown(Request_Abstract $request, Response_Abstract $response)
    {
        $config = Registry::get("config")->smarty->toArray();
        $config['template_dir'] = $config['template_dir'] . $request->module . '/';
        $smarty = new Smarty\Adapter(null, $config);
        Dispatcher::getInstance()->setView($smarty);
    }


}