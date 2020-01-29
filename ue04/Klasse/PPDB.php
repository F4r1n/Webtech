<?php

interface iPPDB {
	public function open();
	public function close($helpRecord);
}


class PPDB extends file implements iPPDB{
	
	function open(){
		return parent::readFile();
	}
	
	function close($helpRecord){
		$record="";

		foreach($helpRecord as $h) {
			$record = $record. " " . $h['Produkt']  . " -> " . $h['Preis']. "\n";
		}
		echo 'Schreibe Hash-Wert: <b>' . $record . '</b>';
		parent::writeFile($record);
	}
}

?>