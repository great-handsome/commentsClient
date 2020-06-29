<?php
namespace CommentsClient\Classes;

class Request {
	
	private $config;
	private $http_request;
	
	public function __construct($config = [],$requestObj = null) {
		$this->config = $config;
		if( empty($this->config) || is_null($requestObj) )
			throw new \Exception('Empty config or request object');
		
		$this->http_request = $requestObj;
	}
	
	public function getRequest() {		
		return $this->http_request->runRequest('GET','/comments');		
	}
	public function postRequest($data = []) {
		//if( empty($data) )
			//throw new \Exception('Empty data');		
		
		return $this->http_request->runRequest('POST','/comment',$data);
	}
	public function putRequest($data = []) {
		//if( empty($data) || empty($data['id']) )
			//throw new \Exception('Empty data or id');
		
		return $this->http_request->runRequest('PUT','/comment/'.$data['id'],$data);
	}
}