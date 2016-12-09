<?php

return [
	'UPLOAD_TMP_PATH' => '/tmp/omg/',
	'MICROSOFT_VISION_TOKEN' => '104f83bb60cd47d78badb30bcda3368c',
	'CLOUDSIGHT_VISION_TOKEN' => 'O1SDWOnqXTTQV5opMbmjIw',

    /* imageteller 的 thrift 服务配置 */
    'OMG_THRIFT' => array(
        'thriftRoot' => __DIR__ . '/../lib/thirdparty/Thrift',
        'packageRoot' => '/home/zhouting/OMG/common/build/gen-php',
        'remoteHost' => 'domob-206.domob-inc.cn',
        'port' => '29900',
        'service' => 'Thrift_OMG/OmgService',
		'clientClass' => '\Thrift_OMG\OmgServiceClient',
    ),
];
