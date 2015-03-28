<?php
/**
 * Created by PhpStorm.
 * User: mingzhil
 * Date: 14/11/17
 * Time: 上午11:02
 */
namespace Utils;

use Yaf\Exception;
use Yaf\Registry;

class Func
{

    public static function NotFound()
    {
        throw new Exception("Page not Found", 404);
    }

    /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    public static function ClientIp($type = 0, $adv = false)
    {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL)
            return $ip[$type];
        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos)
                    unset($arr[$pos]);
                $ip = trim($arr[0]);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }


    /**
     * 根据PHP各种类型变量生成唯一标识号
     * @param mixed $mix 变量
     * @return string
     */
    public static function GuidString($mix)
    {
        if (is_object($mix)) {
            return spl_object_hash($mix);
        } elseif (is_resource($mix)) {
            $mix = get_resource_type($mix) . strval($mix);
        } else {
            $mix = serialize($mix);
        }
        return md5($mix);
    }

    /**
     * smarty 自定义标签
     *
     * @param $config
     * @param null $smarty
     * @return null
     */
    public static function Assets($config, $smarty = null)
    {
        if ($config['url'] && preg_match('/\.(png|jpg|bmp|gif|svg)$/', $config['url'])) {
            echo Registry::get('config')->api['static_image'] . $config['url'] . '?' . Registry::get('config')->api['static_assets_date'];
        } else {
            echo Registry::get('config')->api['static_assets'] . $config['url'] . '?' . Registry::get('config')->api['static_assets_date'];
        }
        return null;
    }

    /**
     * 当前URL地址
     *
     * @return string
     */
    public static function SeftUrl()
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }


    /**
     *
     *
     * @param $id
     * @return string
     */
    public static function CardCode($id)
    {
        $id = base_convert($id, 10, 27);
        $code = str_replace("o", "z", str_replace("i", "y", str_replace("1", "x", str_replace("0", "w", str_pad($id, 6, "0", STR_PAD_LEFT)))));
        return strtoupper($code);
    }

}
