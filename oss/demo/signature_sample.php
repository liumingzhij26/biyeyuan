<?php
require_once 'sample_base.php';
//初始化
$bucket = SampleUtil::get_bucket_name();
$oss = SampleUtil::get_oss_client();
SampleUtil::create_bucket();
$object = "test/test-signature-test-upload-and-download.txt";

/*%**************************************************************************************************************%*/
// 签名url 相关
/**
 *生成GetObject的签名url,主要用于私有权限下的读访问控制
 */
get_sign_url_for_get($oss);
function get_sign_url_for_get($oss){
    global $bucket;
    global $object;
	$timeout = 3600;
	$response = $oss->get_sign_url($bucket, $object, $timeout);
    SampleUtil::my_echo("签名的URL为:" . $response);

    /*可以类似的代码来访问签名的URL，也可以输入到浏览器中去访问
    */
	$request = new RequestCore($response);
	$request->set_method('GET');
	$request->add_header('Content-Type', '');
	$request->send_request();
	$res =  new ResponseCore($request->get_response_header(), $request->get_response_body(), $request->get_response_code());
	if ($res->isOK()) {
        SampleUtil::my_echo("签名下载成功");
    } else {
        SampleUtil::my_echo("签名下载失败");
    };
}

/**
 *生成GetObject的签名url,主要用于私有权限下的读访问控制
 */
get_sign_url_for_get_http_headers($oss);
function get_sign_url_for_get_http_headers($oss){
    global $bucket;
    global $object;
	$timeout = 3600;

    $options = array(
            'response-content-disposition' => 'attachment; filename="test.jpg"',
            'response-content-type' => 'application/octet-stream',
            'response-content-language' => 'utf-8',
            'response-cache-control' => '中文',
            'response-content-encoding' => 'ok',
            'response-expires' => '1999',
    );

    $ret = $oss->presign_url($bucket, $object, $timeout, 'GET', $options);
    SampleUtil::my_echo("签名的URL为:" . $ret);
    $request = new RequestCore($ret);
    $request->add_header('content-type', '');
    $request->send_request();
    $res =  new ResponseCore($request->get_response_header(), $request->get_response_body(), $request->get_response_code());
	if ($res->isOK()) {
        SampleUtil::my_echo("签名下载成功");
    } else {
        SampleUtil::my_echo("签名下载失败");
    };
}


/**
 *生成PutObject的签名url,主要用于私有权限下的写访问控制
 */
sign_url_for_put($oss);
function sign_url_for_put($obj){
    global $bucket;
    global $object;
	$timeout = 3600;
	
	//通过content上传
    $options = NULL;
    $response = $obj->presign_url($bucket, $object, $timeout, "PUT", $options);
    SampleUtil::my_echo("签名的URL为:" . $response);

	$content = 'abcdefg';
	$request = new RequestCore($response);
	$request->set_method('PUT');
	$request->add_header('Content-Type', '');
	$request->add_header('Content-Length', strlen($content));
	$request->set_body($content);
	$request->send_request();
	$res = new ResponseCore($request->get_response_header(), 
				$request->get_response_body(), $request->get_response_code());
	if ($res->isOK()) {
        SampleUtil::my_echo("签名上传字符串成功");
    } else {
        SampleUtil::my_echo("签名上传字符串失败");
    };

	//通过file上传
	$file = __FILE__;
	if(!file_exists($file)){
		throw new OSS_Exception($file.OSS_FILE_NOT_EXIST);
	}
	$options = array('Content-Type'=>'txt');
    $response = $obj->presign_url($bucket, $object, $timeout, "PUT", $options);
    SampleUtil::my_echo("签名的URL为:" . $response);

	$request = new RequestCore($response);
	$request->set_method('PUT');
	$request->add_header('Content-Type', 'txt');
	$request->set_read_file($file);
	$request->set_read_stream_size(filesize($file));
	$request->send_request();
	$res =  new ResponseCore($request->get_response_header(), 
				$request->get_response_body(), $request->get_response_code());
	if ($res->isOK()) {
        SampleUtil::my_echo("签名上传文件成功");
    } else {
        SampleUtil::my_echo("签名上传字符串失败");
    };
}
?>
