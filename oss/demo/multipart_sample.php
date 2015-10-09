<?php
require_once 'sample_base.php';
//初始化
$bucket = SampleUtil::get_bucket_name();
$oss = SampleUtil::get_oss_client();
SampleUtil::create_bucket();
$object = "test/multipart-test.txt";

/*%**************************************************************************************************************%*/
// Multipart 相关的示例
/**
 *通过multipart上传文件
 *如果上传的文件小于partSize,则直接使用普通方式上传
 */
$filepath = __FILE__; 
$options = array(
		ALIOSS::OSS_FILE_UPLOAD => $filepath,
		'partSize' => 5242880,
	);
$res = $oss->create_mpu_object($bucket, $object,$options);
$msg = "通过multipart上传文件";
OSSUtil::print_res($res, $msg);

/**
 *通过multipart上传整个目录
 */
$dir = "../demo";
$recursive = false;
$res = $oss->create_mtu_object_by_dir($bucket,$dir,$recursive);
if ($res === true) {
    SampleUtil::my_echo("通过multipart上传整个目录成功");
}

/**
 *通过multi-part上传整个目录(新版)
 */
$options = array(
    'bucket' 	=> $bucket,
    'object'	=> 'picture',
    'directory' => '../demo',
);
$res = $oss->batch_upload_file($options);
if ($res === true) {
    SampleUtil::my_echo("通过multipart上传整个目录成功");
}

/**
 *初始化一个分块上传事件, 也就是初始化上传Multipart
 *获取upload id 
 */
$upload_id = $oss->init_multipart_upload($bucket, $object);
SampleUtil::my_echo("初始化一个分块上传事件 upload_id is:" . $upload_id);

/**
 *Upload Part本地上传
 */
//1. 获取的分片
$part_size = 10*1024*1024;
$upload_file = __FILE__;
$upload_filesize = filesize($upload_file);
$pieces = $oss->get_multipart_counts($upload_filesize, $part_size);
$response_upload_part = array();
$upload_position = 0;
$is_check_md5 = true;
foreach ($pieces as $i => $piece) {
    $from_pos = $upload_position + (integer) $piece[$oss::OSS_SEEK_TO];
    $to_pos = (integer) $piece[$oss::OSS_LENGTH] + $from_pos - 1;
    $up_options = array(
        $oss::OSS_FILE_UPLOAD => $upload_file, 
        $oss::OSS_PART_NUM => ($i + 1),
        $oss::OSS_SEEK_TO => $from_pos,
        $oss::OSS_LENGTH => $to_pos - $from_pos + 1,
        $oss::OSS_CHECK_MD5 => $is_check_md5,
    );
    if ($is_check_md5) {
        $content_md5 = OSSUtil::get_content_md5_of_file($upload_file, $from_pos, $to_pos);
        $up_options[$oss::OSS_CONTENT_MD5] = $content_md5;
    }
    //2. 将每一分片上传到OSS
    $response_upload_part[] = $oss->upload_part($bucket, $object, $upload_id, $up_options);
}

$upload_parts = array();
$upload_part_result = true;
foreach ($response_upload_part as $i => $res){
    $upload_part_result = $upload_part_result && $res->isOk();
    $msg = "上传分块到 /" . $bucket . "/" . $object . " upload id is: " . $upload_id;
    OSSUtil::print_res($res, $msg);
    if(!$upload_part_result){
        throw new OSS_Exception('any part upload failed, please try again');
    }
    $upload_parts[] = array(
        'PartNumber' => ($i + 1),
        'ETag' => (string) $res->header['etag']
    );
}

/**
 *获取Bucket内所有分块上传事件
 */
$options = array(
    'key-marker' => "",
    'max-uploads' => 1000,
    'upload-id-marker' => "",
);
$res = $oss->list_multipart_uploads($bucket, $options);
$msg = "获取Bucket内所有分块上传事件";
OSSUtil::print_res($res, $msg);
if ($res->isOK()) {
    SampleUtil::my_echo($res->body);
}

/**
 *获取所有已上传的块信息
 */
$res = $oss->list_parts($bucket, $object, $upload_id);
$msg = "获取所有已上传的块信息";
OSSUtil::print_res($res, $msg);
if ($res->isOK()) {
    SampleUtil::my_echo($res->body);
}

//完成分块上传
#complete as string
#此处只是一个例子，执行不会成功
$msg = "完成分块上传";
$xml_string = '<?xml version="1.0" encoding="utf-8"?><CompleteMultipartUpload><Part><PartNumber>1</PartNumber><ETag>test</ETag></Part></CompleteMultipartUpload>';
$res = $oss->complete_multipart_upload($bucket, $object, $upload_id, $xml_string);
OSSUtil::print_res($res, $msg);

#complete as xml
#此处只是一个例子，执行不会成功
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><CompleteMultipartUpload></CompleteMultipartUpload>');
$part = $xml->addChild('Part');
$part ->addChild('PartNumber', 1);
$part ->addChild('ETag', 'abcdeft');
$input = $xml;
$res = $oss->complete_multipart_upload($bucket, $object, $upload_id, $input);
OSSUtil::print_res($res, $msg);

#complete as array
#执行会成功
$res = $oss->complete_multipart_upload($bucket, $object, $upload_id, $upload_parts);
OSSUtil::print_res($res, $msg);

//取消分块上传事件
$upload_id = $oss->init_multipart_upload($bucket, $object);
SampleUtil::my_echo("初始化一个分块上传事件 upload_id is:" . $upload_id);
$res = $oss->abort_multipart_upload($bucket, $object, $upload_id);
$msg = "取消分块上传事件";
OSSUtil::print_res($res, $msg);
