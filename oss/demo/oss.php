<?php
require_once 'sample_base.php';
//初始化
$bucket = SampleUtil::get_bucket_name();
$oss = SampleUtil::get_oss_client();
$oss->set_enable_domain_style(true);
$list = $oss->list_bucket();


if ($list->isOK()) {
    var_dump(OSSUtil::parse_response($list));
}

echo "<hr/>";

$obj = $oss->list_object($bucket);

var_dump(OSSUtil::parse_response($obj));

echo "<hr/>";


//上传object 相关示例
/**
 *简单上传
 *上传指定变量的内存值

$object = "oss.md";
//echo dirname(__FILE__).DIRECTORY_SEPARATOR.$object;
$content  = 'hello world';
$options = array(
    'content' => $content,
    'length' => strlen($content),
);
$res = $oss->upload_file_by_content($bucket, $object, $options);
$msg = "上传字符串到 /" . $bucket . "/" . $object;
OSSUtil::print_res($res, $msg);

echo "<hr/>";
 */


/**
 *创建模拟文件夹
 *OSS服务是没有文件夹这个概念的，所有元素都是以Object来存储。但给用户提供了创建模拟文件夹的方式

$object = "test";
$res = $oss->create_object_dir($bucket, $object);
$msg = "创建模拟文件夹 /" . $bucket . "/" . $object;
OSSUtil::print_res($res, $msg);
 */

/**
 *简单上传
 *上传指定的本地文件内容
 */
$object = "test";
$file_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'jquery-1.10.1.min.js';
$options = array();
$object = $object.DIRECTORY_SEPARATOR.'jquery-1.10.1.min.js';
$res = $oss->upload_file_by_file($bucket, $object, $file_path, $options);
$msg = "上传本地文件 :" . $file_path . " 到 /" . $bucket . "/" . $object;
OSSUtil::print_res($res, $msg);
echo "<hr/>";
exit;

/**
 *列出Bucket内最多1000个文件
 */
$index = 1;
$options = array();
$res = $oss->list_object($bucket, $options);
$msg = "列出Bucket内最多1000个文件 bucket:" . $bucket;
OSSUtil::print_res($res, $msg);
if ($res->isOk()){
    $body = $res->body;
    $tmp_object_list = OSSUtil::get_object_list_marker_from_xml($body, $next_marker);
    //打印出所有的object名称
    foreach ($tmp_object_list as $key) {
        SampleUtil::my_echo("No. " . $index . " : " . $key);
        $index++;
    }
}

echo "<hr/>";

/**
 *列出Bucket内所有文件
 *递归列出目录下所有文件
 */
$prefix = '';
$marker = '';
$delimiter = '';
$next_marker = '';
$maxkeys = 1000;
$index = 1;
while (true)
{
    $options = array(
        'delimiter' => $delimiter,
        'prefix' => $prefix,
        'max-keys' => $maxkeys,
        'marker' => $next_marker,
    );
    $res = $oss->list_object($bucket, $options);
    $msg = "列出Bucket内所有文件" . $bucket;
    OSSUtil::print_res($res, $msg);
    if ($res->isOk()){
        $body = $res->body;
        $tmp_object_list = OSSUtil::get_object_list_marker_from_xml($body, $next_marker);
        //打印出所有的object名称
        foreach ($tmp_object_list as $key) {
            SampleUtil::my_echo("No. " . $index . " : " . $key);
            $index++;
        }
    }
    if (empty($next_marker))
    {
        break;
    }
}


echo "<hr/>";


/**
 *列出目录下的文件和子目录
 */
$prefix = '';
$marker = '';
$delimiter = '/';
$next_marker = '';
$maxkeys = 1000;
$index = 1;
$options = array(
    'delimiter' => $delimiter,
    'prefix' => $prefix,
    'max-keys' => $maxkeys,
    'marker' => $next_marker,
);
$res = $oss->list_object($bucket, $options);
$msg = "列出目录下的文件和子目录: " . $bucket;
OSSUtil::print_res($res, $msg);
if ($res->isOk()){
    $body = $res->body;
    $xml = new SimpleXMLElement($body);
    foreach ($xml->Contents as $content) {
        SampleUtil::my_echo("文件列表: " . $content->Key);
    }
    foreach ($xml->CommonPrefixes as $content) {
        SampleUtil::my_echo("子目录列表: " . $content->Prefix);
    }
}
