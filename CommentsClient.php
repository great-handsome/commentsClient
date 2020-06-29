<?php

use CommentsClient\Classes\Request;
use CommentsClient\Classes\HttpRequest;

class CommentsClient {
	
	public $protocolRequestObj = null;
	public $config;
	
	public function __construct($ProtocolRequestObj = null,$config =[]) {
		if( !empty($config) )
			$this->config = $config;
		else
			$this->config = require_once(__DIR__.'/config/config.php');
		if( empty($this->config) )
			throw new \Exception('Empty config');
		
		if( !is_null($ProtocolRequestObj) ) {
			$this->protocolRequestObj = $ProtocolRequestObj;
		}
		else
			$this->protocolRequestObj = new HttpRequest($this->config['http-request']);
		
	}
		
	public function getRequest() {
		$this->request = new Request($this->config,$this->protocolRequestObj);
		return $this->request->getRequest();
	}
	public function postRequest($data = []) {
		$this->request = new Request($this->config,$this->protocolRequestObj);
		return $this->request->postRequest($data);		
	}
	public function putRequest($data = []) {
		$this->request = new Request($this->config,$this->protocolRequestObj);
		return $this->request->putRequest($data);
	}
}

