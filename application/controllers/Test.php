<?php
use Yaf\Dispatcher;
use Yaf\Controller_Abstract as Controller;
use \Response\Response;
use AliOSS\util\OSSUtil;

class TestController extends Controller
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
        $Base = \AliOSS\Base::Instance();
        $Base->getALIOSSSDK()->setEnableDomainStyle(true);
        $data['list'] = $Base->getALIOSSSDK()->listBucket();


        /**
         *列出Bucket内所有文件
         *递归列出目录下所有文件
         */
        $prefix = '';
        $marker = '';
        $delimiter = '';
        $next_marker = '';
        $maxkeys = 1000;
        $index = 1;
        while (true)
        {
            $options = array(
                'delimiter' => $delimiter,
                'prefix' => $prefix,
                'max-keys' => $maxkeys,
                'marker' => $next_marker,
            );
            $res = $Base->getALIOSSSDK()->listObject($Base->getBucketName(), $options);
            $msg = "列出Bucket内所有文件" . $Base->getBucketName();
            if ($res->isOk()){
                $body = $res->body;
                $tmp_object_list = OSSUtil::get_object_list_marker_from_xml($body, $next_marker);
                //打印出所有的object名称
                foreach ($tmp_object_list as $key) {
                    $data['file'][$index] = $key;
                    $index++;
                }
            }
            if (empty($next_marker))
            {
                break;
            }
        }
        Response::Json($data);
    }

}
