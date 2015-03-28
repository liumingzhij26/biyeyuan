<?php
use Yaf\Dispatcher;
use Services\TestService as Test;
use Yaf\Controller_Abstract as Controller;

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

//        $str = 'id###106!!!app###weixin_red_packet!!!name###adv_img!!!value###!!!description###页面底部广告图片@@@id###75!!!app###weixin_red_packet!!!name###adv_link!!!value###http://s.h5.jumei.com/pages/1651?3!!!description###页面底部广告链接@@@id###76!!!app###weixin_red_packet!!!name###adv_title!!!value###广告图片!!!description###广告标题（暂时无用）@@@id###77!!!app###weixin_red_packet!!!name###content_assist!!!value###聚美3月1日周年庆#百万感恩红包送不停!!!description###内容方案，必须使用#换行@@@id###78!!!app###weixin_red_packet!!!name###content_index!!!value###聚美3月1日周年庆#百万感恩红包送不停!!!description###内容方案，必须使用#换行@@@id###79!!!app###weixin_red_packet!!!name###content_open!!!value###聚美3月1日周年庆#百万感恩红包送不停!!!description###内容方案，必须使用#换行@@@id###80!!!app###weixin_red_packet!!!name###content_share!!!value###聚美3月1日周年庆#百万感恩红包送不停!!!description###内容方案，必须使用#换行@@@id###81!!!app###weixin_red_packet!!!name###content_title!!!value###聚美发红包啦!!!description###公共标题@@@id###82!!!app###weixin_red_packet!!!name###count_assist!!!value###3!!!description###最多只能多少次（暂时无用）@@@id###83!!!app###weixin_red_packet!!!name###count_promo_card!!!value###3!!!description###第几次时返现金券（暂时无用）@@@id###84!!!app###weixin_red_packet!!!name###count_self_assist!!!value###5!!!description###最多可抢几个朋友的红包@@@id###85!!!app###weixin_red_packet!!!name###expire_time!!!value###2015-02-26!!!description###现金券过期时间@@@id###107!!!app###weixin_red_packet!!!name###headimgurl!!!value###http://p0.jmstatic.com/mcms/weixinmorentouxiang.png!!!description###微信默认头像（用户的微信头像为空时使用）@@@id###86!!!app###weixin_red_packet!!!name###img_share!!!value###http://p0.jmstatic.com/mcms/2.pic_hd.jpg!!!description###分享图片@@@id###87!!!app###weixin_red_packet!!!name###max_redpacket!!!value###4!!!description###助力最多送多少（设定金额除以10为真实金额）@@@id###88!!!app###weixin_red_packet!!!name###min_redpacket!!!value###1!!!description###助力最少送多少（设定金额除以10为真实金额）@@@id###89!!!app###weixin_red_packet!!!name###one_redpacket!!!value###5!!!description###第一次打开红包送多少@@@id###90!!!app###weixin_red_packet!!!name###price_promo_card!!!value###88!!!description###现金券送多少@@@id###91!!!app###weixin_red_packet!!!name###promo_card!!!value###100,8#150,15#200,20#200,20#250,25!!!description###现金券规则@@@id###92!!!app###weixin_red_packet!!!name###reach_redpacket!!!value###10!!!description###达到多少时@@@id###93!!!app###weixin_red_packet!!!name###scope_id!!!value###10258!!!description###现金券使用范围ID「仅限团购商品使用(包括海淘商品)）」@@@id###94!!!app###weixin_red_packet!!!name###send_date!!!value###2015.03.10!!!description###统一返时间@@@id###95!!!app###weixin_red_packet!!!name###share_assist!!!value###新年红包帮帮抢，你抢红包我也得～#100%中奖进行时，话费和88元礼包可以兼得！!!!description###分享文案：（得到红包后分享给朋友)@@@id###96!!!app###weixin_red_packet!!!name###share_assist:circle!!!value###新年红包帮帮抢，你抢红包我也得～100%中奖进行时，话费和88元礼包可以兼得！!!!description###分享文案：（得到红包后分享到朋友圈)@@@id###97!!!app###weixin_red_packet!!!name###share_index!!!value###第一个拜早年的红包来啦～#100万红包发放进行中，最低也是88元大礼包，另有话费额外送！!!!description###分享活动（从聚美APP分享给朋友）@@@id###98!!!app###weixin_red_packet!!!name###share_index:circle!!!value###第一个拜早年的红包来啦，话费和88元大礼包可以兼得，100%可得进行中！!!!description###分享活动（从聚美APP分享到朋友圈）@@@id###99!!!app###weixin_red_packet!!!name###share_main!!!value###新年红包帮帮抢，你抢红包我也得～#100%中奖进行时，话费和88元礼包可以兼得！!!!description###分享文案：（得到红包后分享给朋友)@@@id###100!!!app###weixin_red_packet!!!name###share_main:circle!!!value###新年红包帮帮抢，你抢红包我也得～100%中奖进行时，话费和88元礼包可以兼得！!!!description###分享文案：（得到红包后分享到朋友圈)@@@id###101!!!app###weixin_red_packet!!!name###share_open!!!value###88元红包等你来领#帮我抢红包你也会得到话费和88元大礼包噢！!!!description###open_主标题#副标题（暂时无用）@@@id###102!!!app###weixin_red_packet!!!name###share_open:circle!!!value###88元的大礼包，帮我抢自己也可以得到话费和88元红包噢！!!!description###open_朋友圈主标题（暂时无用）@@@id###103!!!app###weixin_red_packet!!!name###share_share!!!value###新年红包帮帮抢，你抢红包我也得～#100%中奖进行时，话费和88元礼包可以兼得！!!!description###拆红包页面（分享给朋友）@@@id###104!!!app###weixin_red_packet!!!name###share_share:circle!!!value###新年红包帮帮抢，你抢红包我也得～100%中奖进行时，话费和88元礼包可以兼得！!!!description###拆红包页面（分享到朋友圈）@@@id###105!!!app###weixin_red_packet!!!name###state!!!value###YES!!!description###活动结束';
//        $data = explode('@@@', $str);
//        echo "<pre>";
//
//        foreach ($data as $key => $val) {
//            $data[$key] = explode('!!!', $val);
//            foreach ($data[$key] as $k => $v) {
//                $data[$key][$k] = explode('###', $v);
//                $data[$key][$data[$key][$k][0]] = $data[$key][$k][1];
//                unset($data[$key][$k]);
//            }
//        }
//        $path = getcwd();
        //echo file_put_contents($path.'/1.txt',json_encode($data));
        $path = getcwd();
        $data = file_get_contents($path.'/1.txt');
        $data = json_decode($data, true);
        foreach($data as $key => $val ) {
            $sql = "INSERT INTO `mobile`.`options` (`id`, `app`, `name`, `value`, `description`)
                    VALUES ('{$val['id']}', '{$val['app']}', '{$val['name']}', '{$val['value']}', '{$val['description']}');";
            //echo $sql."<br/>";
        }

        $content1 = "尊敬的聚美会员，您参加的聚美抢红包活动，已成功兑换到10元话费，从聚美App首页通过话费领取入口去领话费吧。";
        $content2 = "尊敬的聚美会员，您参加的聚美抢红包活动，已成功兑换到88元大礼包，共计5张现金券，几分钟后会充入您本手机号对应的聚美账户中，敬请查收。";
        $content3 = "亲，您参加的抢红包活动成功兑换88元礼包及10元话费，礼包中的现金券几分钟后会充入本手机号对应聚美账户，同时您需要从聚美App首页通过话费领取入口去领话费。";
        $content4 = "恭喜您已成功兑换到10元话费，但您的该手机号还未注册聚美，您用该号码在移动端注册聚美账户后，从聚美App首页通过话费领取入口去领话费。下载连接：http://d.jumei.com";
        $content5 = "恭喜您已成功兑换到88元大礼包，但您输入的手机号没有对应的聚美账户，用本号码在移动端注册聚美后，会自动充入该账户，快来注册领取吧！下载连接：http://d.jumei.com";
        $content6 = "恭喜您已成功兑换到88元大礼包及10元话费，但您输入的手机号没有对应的聚美账户，用本号码在聚美App注册聚美后，礼包会自动充入该账户，同时从聚美App首页通过话费领取入口去领话费。App下载连接：http://d.jumei.com";

        for($i = 1;$i < 10; $i++) {
            $name = 'content'.$i;
            $sql = "INSERT INTO `mobile`.`options` (`app`, `name`, `value`, `description`)
                    VALUES ('weixin_red_packet', 'send_info{$i}', '{$$name}', '短信{$i}');";
            echo $sql;
            echo "<br/>";
        }
    }

}
