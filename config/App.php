<?php
/**
 * This file is generated automatically by ConfigurationSystem.
 * Do not change it manually in production, unless you know what you're doing and can take responsibilities for the consequences of changes you make.
 */

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/24
 * Time: 下午6:54
 */
namespace Config;
class App
{


    /**
     * @var string 开发环境
     */
    public $environment = 'dev';

    public $platform = "pc";

    public $version = '1.1';

    public $cache = array(
        //缓存类型
        "type" => "file",
        //缓存路径
        "temp" => "/home/logs/file_cache/",
        //缓存前缀
        "prefix" => "",
        //默认过期时间
        "expire" => 1000,
        //长度
        "length" => 0,
        //文件缓存子目录，为了防止单个目录下文件数过多,1为开启
        "subdir" => 1,
        //子目录缓存级别
        "temp_level" => 1
    );

    public $api = array(
        'static_image' => 'http://biyeyuan.com/',
        'static_assets' => 'http://biyeyuan.com/',
        'static_assets_date' => '201502021212',
    );

}
