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
namespace config\db;

class Redis
{


    public $storage = [
        'default' => [
            'tcp://127.0.0.1:6379',
            'tcp://127.0.0.1:6379'
        ],
    ];

    public $cache = [
        'default' => [
            'tcp://127.0.0.1:6379',
            'tcp://127.0.0.1:6379'
        ],
    ];
}
