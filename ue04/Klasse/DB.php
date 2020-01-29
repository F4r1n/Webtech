<?php

interface iDatenbank
{
    public function open();
    public function insert($record);
    public function query($name,$string);
    public function delete($name,$string);
    public function close();
}


class DB implements iDatenbank
{
    function open()
    {
        $host = "localhost";
        $user   = "root";
        $password   = "";
        $db = "datenbank";

        try {
            //Verbindung herstellen
            $pdo = new PDO("mysql:host=$host;dbname=".$db, $user, $password, array(PDO::ATTR_PERSISTENT => true));
            //Warnungen anzeigen
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            echo "Erfolgreich verbunden\n";
            return $pdo;
        }
        catch (PDOException $e) {
            echo "Verbindung fehlgeschlagen: " . $e->getMessage(). "\n";
        }
    }
	
    function insert($record)
    {
        $pdo = $this->open();
        
	    foreach($record as $r) {
            //Prepare statement
            $stmt = $pdo->prepare("INSERT INTO lebensmittel (Produkt, Preis) VALUES ( :Produkt, :Preis)"); 
            $stmt->bindParam(':Produkt', $r['Produkt']);
            $stmt->bindParam(':Preis', $r['Preis']);

            if (!$stmt->execute()) {	
                print_r("Es ist ein Fehler beim Ausführen des Befehls aufgetreten. Bitte versuchen Sie es erneut!\n");        
            } else {
                print_r("Zeile erfolgreich hinzugefügt\n");	
            }
        }
	}
	
    function query($name, $string)
    {
        $pdo = $this->open();
        //Prepare statement
		$stmt = $pdo->prepare("SELECT :s from `lebensmittel` WHERE `Produkt` = :n");
		$stmt->bindParam(':n', $name);
        $stmt->bindParam(':s', $string);
		$stmt->execute();

        if ($stmt->rowCount() > 0) {
            //Zeile aus dem resultSet gewinnen
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            print_r($row);
        } else {
            echo "Zeile nicht gefunden\n";
        }
	}
	
    function delete($name, $string)
    {
		$pdo = $this->open();
        $stmt = $pdo->prepare("Delete from `lebensmittel` WHERE ' :p ' = ' :s ' order by 'id' LIMIT 1");
        $stmt->bindParam(':p', $name);
		$stmt->bindParam(':s', $string);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
			echo "Zeile erfolgreich gelöscht\n";
		} else {
            echo "Zeile nicht gelöscht. Bitte erneut versuchen.\n";
        }
    }
    
    function close(){
        try {
            //Verbindung kann nur manuell geschlossen werden, wenn das PDO Objekt auf NULL gesetzt wird
            $pdo = null;
        } catch (PDOException $e) {
            echo "Trennung fehlgeschlagen: " . $e->getMessage(). "\n";
        }
    }
}
?>
