<?php
require_once 'sample_base.php';
//初始化
$bucket = SampleUtil::get_bucket_name();
$oss = SampleUtil::get_oss_client();
SampleUtil::create_bucket();

/*%**************************************************************************************************************%*/
//上传object 相关示例
/**
 *简单上传
 *上传指定变量的内存值
 */
$object = "oss-php-sdk-test/upload-test-object-name.txt";
$content  = 'hello world';
$options = array(
    'content' => $content,
    'length' => strlen($content),
);
$res = $oss->upload_file_by_content($bucket, $object, $options);	
$msg = "上传字符串到 /" . $bucket . "/" . $object;
OSSUtil::print_res($res, $msg);

/**
 *上传时设定Object的Http Header
 *上传指定变量的内存值
 *指定object的content-type, 如果不指定的话，会根据object的后缀去 mimetypes.class.php 中获取
 *指定object的常用HTTP头部 Cache-Control 、 Content-Disposition 、Content-Encoding 、 Expires 
 */
$options = array(
    'content' => $content,
    'length' => strlen($content),
    ALIOSS::OSS_HEADERS => array(
        'Expires' => '2012-10-01 08:00:00',
        'Cache-Control' => '2012-10-01 08:00:00',
        'Content-Disposition' => 'just-for-test',
        'Content-Type' => 'text/plain2',
        'Content-Encoding' => 'utf-8',
        'Content-Type' => 'text/plain',
    ),
);
$res = $oss->upload_file_by_content($bucket, $object, $options);	
$msg = "上传字符串到 /" . $bucket . "/" . $object;
OSSUtil::print_res($res, $msg);

/**
 *上传时设定设置User Meta
 *上传指定变量的内存值
 *User Meta 指定用户自定义的以x-oss-meta-开头的信息
 *指定object的content-type, 如果不指定的话，会根据object的后缀去 mimetypes.class.php 中获取
 */
$options = array(
    'content' => $content,
    'length' => strlen($content),
    ALIOSS::OSS_HEADERS => array(
        'Content-Type' => 'text/plain',
        'x-oss-meta-self-define-title' => 'user define meta info',
    ),
);
$res = $oss->upload_file_by_content($bucket, $object, $options);	
$msg = "上传字符串到 /" . $bucket . "/" . $object;
OSSUtil::print_res($res, $msg);

/**
 *创建模拟文件夹
 *OSS服务是没有文件夹这个概念的，所有元素都是以Object来存储。但给用户提供了创建模拟文件夹的方式
 */
$object = "test/testa/testb";
$res = $oss->create_object_dir($bucket, $object);
$msg = "创建模拟文件夹 /" . $bucket . "/" . $object;
OSSUtil::print_res($res, $msg);

/**
 *简单上传
 *上传指定的本地文件内容
 */
$file_path = __FILE__;
$options = array();
$res = $oss->upload_file_by_file($bucket, $object, $file_path, $options);
$msg = "上传本地文件 :" . $file_path . " 到 /" . $bucket . "/" . $object;
OSSUtil::print_res($res, $msg);

/**
 *上传时设定Object的Http Header
 *上传指定的本地文件内容
 *指定object的content-type, 如果不指定的话，会根据上传的本地文件的后缀去 mimetypes.class.php 中获取
 *指定object的常用HTTP头部 Cache-Control 、 Content-Disposition 、Content-Encoding 、 Expires 
 */
$options = array(
    ALIOSS::OSS_HEADERS => array(
        'Expires' => '2012-10-01 08:00:00',
        'Cache-Control' => '2012-10-01 08:00:00',
        'Content-Disposition' => 'just-for-test',
        'Content-Encoding' => 'utf-8',
        'Content-Type' => 'text/plain2',
    ),
);
$res = $oss->upload_file_by_file($bucket, $object, $file_path, $options);
$msg = "上传本地文件 :" . $file_path . " 到 /" . $bucket . "/" . $object;
OSSUtil::print_res($res, $msg);

/**
 *上传时设定设置User Meta
 *上传指定的本地文件内容
 *User Meta 指定用户自定义的以x-oss-meta-开头的信息
 *指定object的content-type, 如果不指定的话，会根据上传的本地文件的后缀去 mimetypes.class.php 中获取
 */
$options = array(
    ALIOSS::OSS_HEADERS => array(
        'Content-Type' => 'text/plain2',
        'x-oss-meta-self-define-title2' => 'user define meta info',
    ),
);
$res = $oss->upload_file_by_file($bucket, $object, $file_path, $options);
$msg = "上传本地文件 :" . $file_path . " 到 /" . $bucket . "/" . $object;
OSSUtil::print_res($res, $msg);


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

/**
 *获取object
 *将object下载到指定的文件
 */
$localfile = "test_get_object.txt";
$options = array(
		ALIOSS::OSS_FILE_DOWNLOAD => $localfile,
	);	
$res = $oss->get_object($bucket, $object, $options);
$msg = "下载 object /" . $bucket . "/" . $object . " 到本地文件:" . $localfile;
OSSUtil::print_res($res, $msg);
if(file_exists($localfile)){
    unlink($localfile);
}

/**
 *获取object
 *将object下载到内存中
 */
$options = array();	
$res = $oss->get_object($bucket, $object, $options);
$msg = "下载 object /" . $bucket . "/" . $object . " 到字符串";
$string = $res->body;
OSSUtil::print_res($res, $msg);

/**
 *拷贝object
 *当目的object和源object完全相同时，表示修改object的meta信息
 */
$from_bucket = $bucket;
$from_object = $object;
$to_bucket = $bucket;
$to_object = $object . $object;
$options = array();
$res = $oss->copy_object($from_bucket, $from_object, $to_bucket, $to_object, $options);
$msg = "拷贝object 从  /" . $from_bucket . "/" . $from_object . " 到 /". $to_bucket . "/" . $to_object;
OSSUtil::print_res($res, $msg);
/**
 *拷贝object
 *修改Object Meta
 *当目的object和源object完全相同时，表示修改object的meta信息
 */
$to_object = $from_object;
$copy_options = array(
    ALIOSS::OSS_HEADERS => array(
        'Expires' => '2012-10-01 08:00:00',
        'Content-Disposition' => 'attachment; filename="xxxxxx"',
    ),
);
$res = $oss->copy_object($from_bucket, $from_object, $to_bucket, $to_object, $options);
$msg = "修改Object Meta /" . $from_bucket . "/" . $from_object ;
OSSUtil::print_res($res, $msg);

/**
 *获取object meta, 也就是head object接口
 */
$res = $oss->get_object_meta($bucket, $object);
$msg = "获取object meta";
OSSUtil::print_res($res, $msg);
if ($res->isOK()) {
    SampleUtil::my_echo("object content-type is " . $res->header['content-type']);
    SampleUtil::my_echo("object content-length is " . $res->header['content-length']);
}

/**
 *删除object
 */
$res = $oss->delete_object($bucket, $object);
$msg = "删除object";
OSSUtil::print_res($res, $msg);

/**
 *批量删除object
 */
$objects = array($object);   
$options = array();
$res = $oss->delete_objects($bucket, $objects, $options);
$msg = "批量删除object";
OSSUtil::print_res($res, $msg);

/**
 *判断object是否存在
 */
$res = $oss->is_object_exist($bucket, $object);
if ($res->status === 404) {
    SampleUtil::my_echo("object 不存在");
}
if ($res->status === 200) {
    SampleUtil::my_echo("object 存在");
}

