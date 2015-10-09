<?php
namespace alioss;

//关于endpoint的介绍见, endpoint就是OSS访问的域名
use \config\AliOSS;
use alioss\util\OSS_Exception;
//设置默认时区
date_default_timezone_set('Asia/Shanghai');
set_time_limit(0);

//检测API路径
if (!defined('OSS_API_PATH'))
    define('OSS_API_PATH', dirname(__FILE__));

//加载conf.inc.php文件,里面保存着OSS的地址以及用户访问的ID和KEY
$config = (array)new AliOSS();
define('OSS_ACCESS_ID', $config['Auth']['OSS_ACCESS_ID']);
define('OSS_ACCESS_KEY', $config['Auth']['OSS_ACCESS_KEY']);
define('OSS_ENDPOINT', $config['Auth']['OSS_ENDPOINT']);
define('OSS_TEST_BUCKET', $config['Auth']['OSS_TEST_BUCKET']);

//是否记录日志
define('ALI_LOG', $config['Auth']['ALI_LOG']);

//自定义日志路径，如果没有设置，则使用系统默认路径，在./logs/
//define('ALI_LOG_PATH','');

//是否显示LOG输出
define('ALI_DISPLAY_LOG', $config['Auth']['ALI_DISPLAY_LOG']);

//语言版本设置
define('ALI_LANG', $config['Auth']['ALI_LANG']);

//检测语言包
if (file_exists(OSS_API_PATH . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . ALI_LANG . '.inc.php')) {
    require_once OSS_API_PATH . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . ALI_LANG . '.inc.php';
} else {
    throw new OSS_Exception(OSS_LANG_FILE_NOT_EXIST);
}

//定义软件名称，版本号等信息
define('OSS_NAME', 'aliyun-oss-sdk-php');
define('OSS_VERSION', '1.1.7');
define('OSS_BUILD', '20150311');
define('OSS_AUTHOR', 'xiaobing');

//检测get_loaded_extensions函数是否被禁用。由于有些版本把该函数禁用了，所以先检测该函数是否存在。
if (function_exists('get_loaded_extensions')) {
    //检测curl扩展
    $enabled_extension = array("curl");
    $extensions = get_loaded_extensions();
    if ($extensions) {
        foreach ($enabled_extension as $item) {
            if (!in_array($item, $extensions)) {
                throw new OSS_Exception("Extension {" . $item . "} has been disabled, please check php.ini config");
            }
        }
    } else {
        throw new OSS_Exception(OSS_NO_ANY_EXTENSIONS_LOADED);
    }
} else {
    throw new OSS_Exception('Function get_loaded_extensions has been disabled, please check php config.');
}



class Base
{
    const endpoint = OSS_ENDPOINT;
    const accessKeyId = OSS_ACCESS_ID;
    const accesKeySecret = OSS_ACCESS_KEY;
    const bucket = OSS_TEST_BUCKET;

    static public $instance;

    /**
     * @return Base
     */
    static public function Instance()
    {
        $class = get_called_class();
        if (empty(self::$instance[$class])) {
            self::$instance[$class] = new $class();
        }
        return self::$instance[$class];
    }

    /**
     * @return ALIOSSSDK
     */
    public function getALIOSSSDK()
    {
        if (empty(self::$instance['ALIOSSSDK'])) {
            self::$instance['ALIOSSSDK'] = new ALIOSSSDK(self::accessKeyId, self::accesKeySecret, self::endpoint);
        }
        return self::$instance['ALIOSSSDK'];
    }

    public function getBucketName() {
        return self::bucket;
    }


}
