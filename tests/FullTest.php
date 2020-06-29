<?php
namespace CommentsClient\Tests;

use PHPUnit\Framework\TestCase;
use CommentsClient\Classes\HttpRequest;
use CommentsClient\Classes\Request;

require_once ( __DIR__.'/../CommentsClient.php');

$GLOBALS['config'] = require_once(__DIR__.'/../config/config.php');

class FullTest extends TestCase {
	
	public $exmaple_request;
	public $mock_http_request;
	
	public function __construct($name = NULL, array $data = array(), $dataName = '') {
		parent::__construct($name, $data, $dataName);

		$this->mock_http_request = $this->getMockBuilder(HttpRequest::class)
			->setMethods(['runRequest'])
			->setConstructorArgs( [ $GLOBALS['config']['http-request'] ] )
			->getMock();
	}

	public static function setUpBeforeClass() {
        if( empty($GLOBALS['config']) )
			throw new \Exception('Empty config');
    }
	
	/**
     * @dataProvider getRequestProvider
     */
	public function testGetRequest($data , $expected ) {
		$this->mock_http_request
			->method('runRequest')
			->will($this->returnValue($expected));
		
		$this->mock_http_request->expects($this->once())
			->method('runRequest')
			->with( 'GET','/comments')
			->will($this->returnValue($expected));
		
		$this->exmaple_request = new \CommentsClient($this->mock_http_request,$GLOBALS['config']);		
		$res = $this->exmaple_request->getRequest($data);
		
	}
	
	public function getRequestProvider() {
        return [
            'get_request_1' => [ null, ['success' => true, 'comments' => [ [ 'id' => 1, 'name' => 'Tester', 'Comment from Vlad' ] ] ] ],
			'get_request_2' => [ [], ['success' => true, 'comments' => [ [ 'id' => 1, 'name' => 'Tester', 'Comment from Vlad' ] ] ] ],
        ];
    }
	
	/**
     * @dataProvider postRequestProvider
     */
	public function testPostRequest($data , $expected ) {
		$this->mock_http_request
			->method('runRequest')
			->will($this->returnValue($expected));	
		
		$this->mock_http_request->expects($this->once())
			->method('runRequest')
			//->with( 'POST','/comment',$data)
			->will($this->returnValue($expected));
		
		$this->exmaple_request = new \CommentsClient($this->mock_http_request,$GLOBALS['config']);		
		$res = $this->exmaple_request->postRequest($data);		
	}
	public function postRequestProvider() {
        return [
            [ [ 'id' => null, 'name' => null, 'test' => null ], [ 'success' => false ] ],
			[ [ 'id' => null, 'name' => '', 'test' => '' ], [ 'success' => false ] ],
			[ [ 'id' => null, 'name' => 'Tester', 'test' => null ], [ 'success' => false ] ],			
			[ ['id' => 1, 'name' => 'Tester', 'text' => 'Comment from Tester'], [ 'success' => false ] ],
			
			[ [ 'name' => 'Tester', 'text' => 'Comment from Tester'], [ 'success' => true ] ],
			[ ['id' => null, 'name' => 'Tester', 'text' => 'Comment from Tester'], [ 'success' => true ] ],
            
        ];
    }
	
	/**
     * @dataProvider putRequestProvider
     */
	public function testPutRequest($data , $expected ) {
		$this->mock_http_request
			->method('runRequest')
			->will($this->returnValue($expected));	
		
		$this->mock_http_request->expects($this->once())
			->method('runRequest')
			//->with( 'PUT','/comment/'.$data['id'],$data)
			->will($this->returnValue($expected));
		
		$this->exmaple_request = new \CommentsClient($this->mock_http_request,$GLOBALS['config']);		
		$res = $this->exmaple_request->putRequest($data);
		
	}
	public function putRequestProvider() {
        return [
            [ [ 'id' => null, 'name' => null, 'test' => null ], [ 'success' => false ] ],
			[ [ 'id' => null, 'name' => '', 'test' => '' ], [ 'success' => false ] ],
			[ [ 'id' => null, 'name' => 'Tester', 'test' => null ], [ 'success' => false ] ],			
			[ ['id' => null, 'name' => 'Tester', 'text' => 'Comment from Tester'], [ 'success' => false ] ],
			[ ['id' => '', 'name' => 'Tester', 'text' => 'Comment from Tester'], [ 'success' => false ] ],
			
            [ ['id' => 1, 'name' => 'Tester', 'text' => 'Comment from Tester'], [ 'success' => true ] ],
        ];
    }
}

