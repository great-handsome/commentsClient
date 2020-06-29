<?php
namespace CommentsClient\Classes;

class HttpRequest {
	
	private $config;
	
	public function __construct($config = []) {
//fwrite(STDERR, print_r($config, TRUE));
		if( empty($config) )
			throw new \Exception('Empty config');
		$this->config = $config;
	}
	
	public function runRequest($type = '',$url = '',$data = []) {
		if( empty($type) )
			throw new \Exception('Empty request type');
		
		$curl = curl_init();
		
		$url = $this->config['domain'].$url;
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => $this->config['request-timeout'],
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $type, // "PUT","GET", "POST" ....
			CURLOPT_POSTFIELDS => http_build_query($data),
			CURLOPT_HTTPHEADER => [
				"cache-control: no-cache"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if( !empty($err) ) {
			throw new \Exception(print_r($err,true));
		} else {
			return $response;
		}
		
	}
}