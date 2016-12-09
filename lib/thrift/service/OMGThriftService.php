<?php
namespace app\lib\thrift\service;
use Yii;

class OMGThriftService {
	public $client;
	public $requester;
	
	public $operatorUid;

	//单例模式 私有+静态
	protected static $instance;

	/**
	 * 构造函数
	 */
	private function __construct($config = [], $requester = 'zeus_pmd') {
		$config['class'] = 'app\lib\extensions\CThriftClient';

		try {
			$this->client = Yii::createObject($config);
			$this->client->init();
			$this->client->transport->open();
		} catch (Exception $e) {
			Yii::error($e->getMessage(), D3_LOG_THRIFT);
			throw new \yii\web\HttpException(500, '我觉得我还能抢救一下,别放弃治疗。。。');
		}
		$this->requester = $requester;
	}
	
	private function __clone() {
	}
	
	protected static function _getInstance($config, $requester = 'imageteller_web') {
		if(empty($config)){
			 throw new \yii\base\UserException('config should not be empty!');
		}
		if (!(static::$instance instanceof static)) {
			static::$instance = new static($config, $requester);
		}
		return static::$instance;
	}

	public static function getInstance($config, $requester = 'imageteller_web') {
		return static::_getInstance($config, $requester);
	}

	public function __destruct() {
		$this->client->transport->close();
	}

	/**
	 * 将调用都代理到实际的client上
	 */
	protected function _call($method, $args) {
		try {
			$result = call_user_func_array(array($this->client->client, $method), $args);
			if ($result === null) {
				throw new \Exception("result is null.");
			} else {
				return $result;
			}
		} catch(\Thrift_OMG_Common\OmgException $e) {
			Yii::warning(sprintf("call thrift function %s failed, thrift exception : %s.", $method, $e->message));
			return null;
		} catch(\Exception $e) {
			Yii::error("call thrift function {$method} failed : ".$e->getMessage());
			return null;
		}
	}

	public function __call($method, $args){
		Yii::info(sprintf("call thrift function %s, args %s", $method, var_export($args, true)));
		return $this->_call($method, $args);
	}
}

