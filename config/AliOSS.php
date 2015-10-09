<?php

/**
 * 阿里云CDN配置文件
 *
 * @author mingzhil
 * @mail liumingzhij26@qq.com
 */
namespace config;

class AliOSS
{
    /**
     * 只允许修改参数，其他不能改变
     */
    public $Auth = array(
        'OSS_ACCESS_ID' => 'ouPEG3yPIkwCrJFZ',
        'OSS_ACCESS_KEY' => 'c4zRsWNIQiyTueNnxxudxt4BMjR93t',
        'OSS_ENDPOINT' => 'oss-cn-beijing.aliyuncs.com',
        'OSS_TEST_BUCKET' => 'static-pub',
        'ALI_LOG' => false,
        'ALI_DISPLAY_LOG' => false,
        'ALI_LANG' => 'zh',
    );
}
