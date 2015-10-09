<?php
namespace Services;

use Services\BaseService as Base;
use Utils\Func;

class TestService extends Base
{
    const MOBILE = 'Mobile';

    /**
     * @return TestService
     */
    static public function Instance()
    {
        return parent::Instance();
    }

    /**
     * 获得DB，选择自己要的数据库
     *
     * @return \lmz\medoo\medoo
     * @throws \Exception
     */
    public function getDb()
    {
        return parent::InstanceDb(self::MOBILE);
    }

    public function setting()
    {
        $data = $this->getDb()->select('options', '*', ['app' => 'weixin_red_packet']);
        $ret = array();
        foreach ($data as $key => $val) {
            $ret[$val['name']] = $val['value'];
            if (strpos($val['name'], 'content') !== false && strpos($val['value'], '#') !== false) {
                list($one, $two) = explode('#', $val['value'], 2);
                $ret[$val['name']] = array('one' => $one, 'two' => $two);
            }
        }
        foreach ($ret as $keys => $value) {
            if (strpos($keys, 'share_') !== false && strpos($value, '#') !== false) {
                list($friend_title, $content) = explode('#', $value, 2);
                $tmp = array(
                    'img_share' => $ret['img_share'],
                    'title' => $ret[$keys . ':circle'],
                    'friend_title' => $friend_title,
                    'content' => $content
                );
                //$ret[$keys.':list'] = $tmp;
                $ret[$keys] = json_encode($tmp);
            }
            if ($keys == 'promo_card' && strpos($value, '#') !== false) {
                $promoList = explode('#', $value);
                foreach ($promoList as $k => $v) {
                    list($min_amount, $amount) = explode(',', $v, 2);
                    $ret['promo_card_list'][] = array(
                        'desti' => 'db',//redis
                        'amount' => $amount,
                        'min_amount' => $min_amount,
                        'expire_time' => strtotime($ret['expire_time']),
                        'card_info' => array(
                            'scope_id' => $ret['scope_id'],
                            'batch_no' => "WeiXin_Red_Bag_{$min_amount}_{$amount}"
                        ),
                    );
                }
                $ret['promo_list'] = $promoList;
            }
        }
        $ret['url'] = 'http://' . $_SERVER['HTTP_HOST'];
        return $ret;
    }
}
