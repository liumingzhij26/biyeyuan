<?php
require_once 'sample_base.php';
//初始化
$bucket = SampleUtil::get_bucket_name();
$oss = SampleUtil::get_oss_client();
SampleUtil::create_bucket();

/*%**************************************************************************************************************%*/
//跨域资源共享（CORS）

/**
 *设定CORS规则
 */
//设置第1条规则
$cors_rule[ALIOSS::OSS_CORS_ALLOWED_HEADER] = array("x-oss-test");
    array_push($cors_rule[ALIOSS::OSS_CORS_ALLOWED_HEADER], "x-oss-test2");
    array_push($cors_rule[ALIOSS::OSS_CORS_ALLOWED_HEADER], "x-oss-test2");
    array_push($cors_rule[ALIOSS::OSS_CORS_ALLOWED_HEADER], "x-oss-test3");
$cors_rule[ALIOSS::OSS_CORS_ALLOWED_METHOD] = array("GET");
    array_push($cors_rule[ALIOSS::OSS_CORS_ALLOWED_METHOD], "PUT");
    array_push($cors_rule[ALIOSS::OSS_CORS_ALLOWED_METHOD], "POST");
$cors_rule[ALIOSS::OSS_CORS_ALLOWED_ORIGIN] = array("http://www.b.com");
    array_push($cors_rule[ALIOSS::OSS_CORS_ALLOWED_ORIGIN], "http://www.a.com");
    array_push($cors_rule[ALIOSS::OSS_CORS_ALLOWED_ORIGIN], "http://www.a.com");
$cors_rule[ALIOSS::OSS_CORS_EXPOSE_HEADER] = array("x-oss-test1");
    array_push($cors_rule[ALIOSS::OSS_CORS_EXPOSE_HEADER], "x-oss-test1");
    array_push($cors_rule[ALIOSS::OSS_CORS_EXPOSE_HEADER], "x-oss-test2");
$cors_rule[ALIOSS::OSS_CORS_MAX_AGE_SECONDS] = 10;

$cors_rules = array($cors_rule);

//设置第2条规则
$cors_rule[ALIOSS::OSS_CORS_ALLOWED_HEADER] = array("x-oss-test");
$cors_rule[ALIOSS::OSS_CORS_ALLOWED_METHOD] = array("GET");
$cors_rule[ALIOSS::OSS_CORS_ALLOWED_ORIGIN] = array("http://www.b.com");
$cors_rule[ALIOSS::OSS_CORS_EXPOSE_HEADER] = array("x-oss-test1");
$cors_rule[ALIOSS::OSS_CORS_MAX_AGE_SECONDS] = 110;

array_push($cors_rules, $cors_rule);

$res = $oss->set_bucket_cors($bucket, $cors_rules);
$msg = "设定CORS规则 bucket " . $bucket;
OSSUtil::print_res($res, $msg);

/**
 *获取CORS规则
 */
get_cors($oss, $bucket);
function get_cors($oss, $bucket) {
    sleep(1);
    $res = $oss->get_bucket_cors($bucket);
    $msg = "获取CORS规则 bucket " . $bucket;
    OSSUtil::print_res($res, $msg);
    if ($res->isOK()) {
        SampleUtil::my_echo($res->body);
    }
    else if ($res->status === 404) {
        SampleUtil::my_echo("无CORS规则");
    }
}

/**
 *删除CORS规则
 */
$res = $oss->delete_bucket_cors($bucket);
$msg = "删除CORS规则 bucket " . $bucket;
OSSUtil::print_res($res, $msg);
get_cors($oss, $bucket);

//防盗链设置
/**
 *设置Referer白名单
 */
$referer_list = array(
    "www.aliiyun.com",
    "www.aliiyuncs.com",
);
$res = $oss->set_bucket_referer($bucket, true, $referer_list);
$msg = "设置Referer白名单 bucket " . $bucket;
OSSUtil::print_res($res, $msg);

/**
 *获取Referer白名单
 */
get_refer($oss, $bucket);
function get_refer($oss, $bucket) {
    $res = $oss->get_bucket_referer($bucket);
    $msg = "获取Referer白名单 bucket " . $bucket;
    OSSUtil::print_res($res, $msg);
    if ($res->isOK()) {
        SampleUtil::my_echo($res->body);
    }
}
/**
 *清空Referer白名单
 *无法删除，只是重新将值置成空
 */
$referer_list = NULL;
$res = $oss->set_bucket_referer($bucket, false, $referer_list);
$msg = "清空Referer白名单 bucket " . $bucket;
OSSUtil::print_res($res, $msg);

//再次获取Referer白名单
get_refer($oss, $bucket);


//生命周期管理（Lifecycle）
/**
 *设置Lifecycle
 */
$lifecycle = "
<LifecycleConfiguration>
   <Rule>
     <ID>delete obsoleted files</ID>
     <Prefix>obsoleted/</Prefix>
     <Status>Enabled</Status>
     <Expiration>   
       <Days>3</Days>
     </Expiration> 
   </Rule>
   <Rule> 
     <ID>delete temporary files</ID>
     <Prefix>temporary/</Prefix>
     <Status>Enabled</Status>
     <Expiration>   
       <Date>2022-10-12T00:00:00.000Z</Date>
     </Expiration>
   </Rule>
</LifecycleConfiguration>";

$res = $oss->set_bucket_lifecycle($bucket, $lifecycle);
$msg = "设置Lifecycle bucket " . $bucket;
OSSUtil::print_res($res, $msg);

/**
 *获取lifecycle规则
 *由于cache的原因，可能不能立即获取lifecycle 规则，可多重试几次
 */
get_lifecycle($oss, $bucket);
function get_lifecycle($oss, $bucket) {
    sleep(1);
    $res = $oss->get_bucket_lifecycle($bucket);
    $msg = "获取lifecycle规则 bucket " . $bucket;
    OSSUtil::print_res($res, $msg);
    if ($res->isOK()) {
        SampleUtil::my_echo($res->body);
    }
    else if ($res->status === 404) {
        SampleUtil::my_echo("无lifecycle规则");
    }
}
/**
 *清空lifecycle规则
 */

$res = $oss->delete_bucket_lifecycle($bucket);
$msg = "清空lifecycle规则 bucket " . $bucket;
OSSUtil::print_res($res, $msg);

//再次获取lifecycle规则
get_lifecycle($oss, $bucket);
