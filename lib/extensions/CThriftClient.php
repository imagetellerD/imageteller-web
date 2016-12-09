<?php
namespace app\lib\extensions;
use Yii;

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\TSocketPool;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TBufferedTransport;
class CThriftClient
{
	public $thriftRoot;
	public $packageRoot;
	public $remoteHost;
	public $port;
	public $service; 
	public $clientClass;
	#public $framed = false;

	public $transport;
	public $protocol;
	public $client;

	public function __construct() {

	}

	public function init() {
		require_once($this->packageRoot.'/'.$this->service.'.php');

		$clientClass = $this->clientClass;
		if (is_array($this->remoteHost)) {
			$socket = new TSocketPool($this->remoteHost, $this->port);
		} else {
			$socket = new TSocket($this->remoteHost, $this->port);
		}
		$socket->setSendTimeout(30000);
		$socket->setRecvTimeout(300000);
		$this->transport = new TBufferedTransport($socket, 1024, 1024);
		$this->transport = new TFramedTransport($this->transport);
		$this->protocol = new TBinaryProtocol($this->transport);
		$this->client = new $clientClass($this->protocol);
	}
/*
	public function initTFramed()
	{
		$GLOBALS['THRIFT_ROOT'] = $this->thriftRoot;
		require_once $GLOBALS['THRIFT_ROOT'].'/Thrift.php';
		require_once $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php';
		require_once $GLOBALS['THRIFT_ROOT'].'/transport/TSocketPool.php';
		require_once $GLOBALS['THRIFT_ROOT'].'/transport/TSocket.php';
		require_once $GLOBALS['THRIFT_ROOT'].'/transport/THttpClient.php';
		require_once $GLOBALS['THRIFT_ROOT'].'/transport/TFramedTransport.php';

		require_once $this->packageRoot.'/'.$this->service.'.php';

		$clientClass = basename($this->service).'Client';

		if (is_array($this->remoteHost)) {
			$socket = new TSocketPool($this->remoteHost, $this->port);
		} else {
			$socket = new TSocket($this->remoteHost, $this->port);
		}
		$socket->setSendTimeout(30000);
		$socket->setRecvTimeout(100000);
		$this->transport = new TFramedTransport($socket, 1024, 1024);
		$this->protocol = new TBinaryProtocol($this->transport);
		$this->client = new $clientClass($this->protocol);
	}
*/
}
