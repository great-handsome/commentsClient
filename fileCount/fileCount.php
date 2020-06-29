<?php

class FileCount {
	public $base_directory = __DIR__.'/directories/';
	public $directory_list = [
		'directoryNumber1/',
		'directoryNumber2/',
		'directoryNumber3/subDirectoryNumber/'
	];

	public function getDirContents($dir, &$results = array()) {
		$files = scandir($dir);

		foreach ($files as $file) {
			$path = realpath($dir . DIRECTORY_SEPARATOR . $file);
			if( !is_dir($path) && $file == 'count') {
				$results = $path;
			} else if ($file != "." && $file != "..") {
				$this->getDirContents($path, $results);
			}
		}

		return $results;
	}


	function run() {
		foreach($this->directory_list as $value) {
			$dir_list = $this->getDirContents($this->base_directory.$value);
			$count_content = file_get_contents($dir_list);
			
			preg_match_all('/[0-9]+/', $count_content, $matches);
			

			echo "\n-----------------------\nFile:\n";
			echo $dir_list."\nFile Count: Sum=".array_sum($matches[0])."\n";
//print_r($count_content."\n");			
//print_r($matches);
		}
	}	
}

$obj = new FileCount();
$obj->run();

