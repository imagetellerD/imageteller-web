<?php

namespace app\models;

use Yii;

use app\lib\thrift\service\OMGThriftService;

require_once __DIR__.'/../lib/thirdparty/Thrift/ClassLoader/ThriftClassLoader.php';
use Thrift\ClassLoader\ThriftClassLoader;

class ThriftAdapter {
	
	static function getImageTellerThrift() {
		$loader = new ThriftClassLoader();   
		$thriftRoot = Yii::$app->params['OMG_THRIFT']['thriftRoot'];
		$packageRoot = Yii::$app->params['OMG_THRIFT']['packageRoot'];				
		$loader->registerNamespace('Thrift', $thriftRoot.'/../');
		$loader->registerDefinition('Thrift_OMG', $packageRoot);
		$loader->register();		
		$thrift = OMGThriftService::getInstance(Yii::$app->params['OMG_THRIFT']);
		return $thrift ? $thrift : null;
	}
}
