<?php

class start {
	private function getDB(){ return new DB(); }

	private function getPPDB(){ return new PPDB(); }
	
	public function insert($record){
		$this->getDB()->insert($record);
		$this->getPPDB()->close($record);		
	}

	public function query($name, $string){
		$this->getDB()->query($name, $string);		
	}
	
	public function delete($name, $string){
		$this->getDB()->delete($name, $string);
	}
	
	public function close(){
		$this->getDB()->close();
	}
	
	public function openHash(){
		return $this->getPPDB()->open();
	}
	
	public function closeHash($record){
		$this->getPPDB()->close($record);
	}
}

?>