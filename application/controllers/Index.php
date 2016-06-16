<?php
use Yaf\Dispatcher;
use Yaf\Controller_Abstract as Controller;

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

    public function tokenAction()
    {
        $config = \TheFairLib\Config\Config::get_union_wechat();
        $token = new \Thenbsp\Wechat\Wechat\AccessToken($config['app_id'],$config['app_secret']);
        print_r($token);

    }


}
