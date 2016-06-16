<?php
/**
 * Created by PhpStorm.
 * User: liumingzhi
 * Date: 15/11/6
 * Time: 下午4:10
 */
use TheFairLib\DB\Redis\Cache;
use TheFairLib\DB\Redis\Storage;
use TheFairLib\Config\Config;
use Illuminate\Database\Capsule\Manager as Capsule;
use TheFairLib\Exception\Api\ApiException;

abstract class BaseModel extends \TheFairLib\Model\DataModel
{

}