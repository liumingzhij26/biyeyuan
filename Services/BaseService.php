<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/24
 * Time: 下午3:22
 */
namespace Services;

use Yaf\Registry;
use \lmz\medoo\medoo;

class BaseService
{

    static protected $instance;

    static protected $cache;

    static protected $db;

    static public function Instance()
    {
        $class = get_called_class();
        if (empty(self::$instance[$class])) {
            self::$instance[$class] = new $class();
        }
        return self::$instance[$class];
    }

    /**
     * 数据库连接
     *
     * @param $dbName
     * @return \lmz\medoo\medoo
     * @throws \Exception
     */
    static public function InstanceDb($dbName)
    {
        if (empty($dbName) && !is_string($dbName)) {
            throw new \Exception('error database name : ' . $dbName);
        }
        if (empty(self::$instance[$dbName])) {
            self::$instance[$dbName] = new medoo($dbName);
        }
        return self::$instance[$dbName];
    }

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __call($name, $arg)
    {
    }

}