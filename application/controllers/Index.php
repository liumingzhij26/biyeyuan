<?php
use Yaf\Dispatcher;
use Services\TestService as Test;
use Yaf\Controller_Abstract as Controller;
use Yaf\Registry;

class IndexController extends Controller
{

    /**
     * 初始化控制器
     */
    public function init()
    {
        //禁止自动加载模板，需要手工指定模板路径
        Dispatcher::getInstance()->autoRender(false);
    }

    public function indexAction()
    {
        $this->getView()->assign("content", "Hello World");
        $this->display('index');
    }

    public function errorAction()
    {
        $this->display('error');
    }

    public function infoAction()
    {
        phpinfo();
    }

    public function testAction()
    {
        $info['test'] = 0;
        if (!empty($info['test'])) {
            \Response\Response::Json($info);
        }
        print_r($info);
    }

    public function cacheAction()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1');
        echo $redis->set('page', '123123123');
    }

    public function getCacheAction()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1');
        $page = $redis->get('page');
        print_r($page);
    }

    public function getdbAction()
    {
        $test = Test::Instance();
        $setting = $test->setting();
        \Response\Response::Json($setting);
    }


}
