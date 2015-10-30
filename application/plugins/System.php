<?php

class SystemPlugin extends Yaf\Plugin_Abstract
{

    public function routerStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response)
    {
        //生成PHPSESSID
        if (empty($_COOKIE['PHPSESSID'])) {
            setcookie("PHPSESSID", $this->genSessionId(), null, '/', $_SERVER['HTTP_HOST']);
        }
    }

    protected function genSessionId()
    {
        return md5(uniqid('SID', true) . mt_rand(0, 999999999));
    }

}
