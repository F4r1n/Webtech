<?php

interface iFile {
	public function getHandle();
	public function writeFile($record);
	public function readFile();
	public function closeFile();
	public function getFilePath();
}

class file implements iFile{	
	private $_fileName = "record";
	
	function getFilePath(){
		return $this->_fileName;
	}
	
	function getHandle(){
		$handle = fopen($this->getFilePath(), "w");
		return $handle;
	}
	
	function closeFile(){
		fclose($this->getHandle());
	}
	
	function readFile(){
		return file_get_contents($this->getFilePath());		
	}
	
	function writeFile($record){
		$handle = $this->getHandle();
		fwrite($handle, $record . "\n");
	}
	
}


?>