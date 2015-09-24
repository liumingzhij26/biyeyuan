<?php
require_once 'sample_base.php';
//初始化
$bucket = SampleUtil::get_bucket_name();
$oss = SampleUtil::get_oss_client();

/*%**************************************************************************************************************%*/
//bucket 相关示例
/**
 *删除bucket
 *如果bucket不为空则bucket无法删除成功
 *不为空表示bucket既没有object，也没有未完成的multipart上传时的parts
 */
$res = $oss->delete_bucket($bucket);
$msg = "删除bucket " . $bucket;
OSSUtil::print_res($res, $msg);

/**
 *创建bucket
 *acl 指的是bucket的访问控制权限，有三种，私有读写，公共读私有写，公共读写。私有读写就是只有bucket的owner才有权限操作
 *三种权限分别对应ALIOSS::OSS_ACL_TYPE_PRIVATE，ALIOSS::OSS_ACL_TYPE_PUBLIC_READ, ALIOSS::OSS_ACL_TYPE_PUBLIC_READ_WRITE 
 */
$acl = ALIOSS::OSS_ACL_TYPE_PUBLIC_READ;
$res = $oss->create_bucket($bucket, $acl);
$msg = "创建bucket " . $bucket;
OSSUtil::print_res($res, $msg);

/**
 *设置bucket acl
 */
$acl = ALIOSS::OSS_ACL_TYPE_PRIVATE;
$res = $oss->set_bucket_acl($bucket, $acl);
$msg = "设置 bucket " . $bucket . " acl 为 " . $acl;
OSSUtil::print_res($res, $msg);

/**
 *获取bucket acl
 */
$res = $oss->get_bucket_acl($bucket);
$msg = "获取 bucket " . $bucket . " acl";
OSSUtil::print_res($res, $msg);
if ($res->isOK()) {
    $xml = new SimpleXMLElement($res->body);
    SampleUtil::my_echo("Bucket acl is " . $xml->AccessControlList->Grant);
}

/**
 *显示创建的bucket
 *列出用户所有的Bucket
 */
$res = $oss->list_bucket();
$msg = "列出用户所有的Bucket";
OSSUtil::print_res($res, $msg);
$index = 1;
$max = 10;
if ($res->isOk()){
    $xml = new SimpleXMLElement($res->body);
    $_bucket_list = array();
    foreach ( $xml->Buckets->Bucket as $_buckets) {
        array_push($_bucket_list, $_buckets->Name);
    }
    foreach ($_bucket_list as $key) {
        SampleUtil::my_echo("Bucket No. " . $index . ": " . $key);
        $index++;
        if ($index > $max) {
            SampleUtil::my_echo("for test, list " . $max . " buckets at most, break");
            break;
        }
    }
}
?>
