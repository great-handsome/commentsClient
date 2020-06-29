<?php

foreach( [ __DIR__ . '/vendor/autoload.php', __DIR__ . '/../vendor/autoload.php', __DIR__ . '/../../autoload.php', __DIR__ . '/vendor/autoload.php'] as $file) {
    if( file_exists($file) ) {
        define('PHPUNIT_COMPOSER_INSTALL', $file);
        break;
    }
}

require_once PHPUNIT_COMPOSER_INSTALL;
require_once __DIR__ .'/CommentsClient.php';

try {
    $object_example_request = new \CommentsClient();
	
	$response = $object_example_request->getRequest();
	print_r($response);
	$response = $object_example_request->postRequest(['name' => 'Tester', 'text' => 'comment text' ]);
	print_r($response);
	$response = $object_example_request->putRequest(['id' => 1 ,'name' => 'Tester', 'text' => 'comment text' ]);	
	print_r($response);
	
} catch (\Exception $e) {
    echo 'Error: ',  $e->getMessage(), "\n";
}

