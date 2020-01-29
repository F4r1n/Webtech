<?php

function __autoload($Klasse){
	require_once 'Klasse/'.$Klasse.".php";
}

$start = new start();
$record[]=array('Produkt'=>'P_Wurst', 'Preis'=>2.0);
$record[]=array('Produkt'=>'P_Zwiebeln', 'Preis'=>1.3);
$start->insert($record);

$start->query('Produkt, Preis','P_Wurst');
$start->query('Produkt, Preis','P_Zwiebeln');

$start->delete('Produkt','P_Wurst');
$start->delete('Produkt', 'P_Zwiebeln');
$start->close();

$start->closeHash($record);
echo 'Hash Wert:' . $start->openHash();

?>