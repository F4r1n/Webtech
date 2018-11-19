<?php
    session_start();
    $_SESSION["iteration"];
?>

<html>
    <head>
        <title>Schere-Stein-Papier-Gruppe07</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
    <h1>Schere-Stein-Papier</h1>
    <br>
    <h2>Das Spiel funktioniert wie folgt: <br></h2>
    <p id="rules">
        Es gibt drei mögliche Eingaben: Schere, Stein oder Papier. Wenn eine Entscheidung für eine dieser Möglichkeiten vom Spieler getroffen wurde <br>
        und diese mit dem "Absenden"-Button gesendet wurde wird die Eingabe gegen eine Zufällige Auswahl des Computers aufgestellt. Dabei gelten folgende Wertigkeiten: <br>
    </p>    
    <div class="centered">
        Schere > Papier <br>
        Papier > Stein <br>
        Stein > Papier <br>
    </div>
    <p id="rules">
        Es gibt auch die Möglichkeit eines Unentschiedens, wenn beide Spieler das gleiche ausgewählt haben. <br>
        Gespielt wird fünf Runden und nach den fünf Runden gibt es eine Auswertung. <br>
    </p>
    <form method="post">
        <fieldset>
            <legend>Das Spiel</legend>
            <input type="radio" name="userInput" value=0> Schere
            <input type="radio" name="userInput" value=1> Stein
            <input type="radio" name="userInput" value=2> Papier
            <input type="submit" name=submit value="Absenden"> 
        </fieldset>          
    </form>                
    <img src="SchereSteinPapier.jpg" alt="Schere-Stein-Papier">


<?php
    $_SESSION["iteration"] = 0;
    $won = 0;
    $lost = 0;
    $draw = 0;
    if (isset($_POST['submit'])) {
        $_SESSION["iteration"]++;
        $i = $_SESSION["iteration"];
        $user = [
            $i => $_POST['userInput']
        ];
        $computer = [
            $i => rand(0, 2)
        ];

        #Table Start
        echo "<table>
        <tr>
            <th> Runde </th>
            <th> Eingaben (User:PC) </th>
            <th> Ergebnis </th>
        </tr>";

        foreach($user as $key => $value){
            if(($value == 0 && $computer[$key] == 2) || ($value == 1 && $computer[$key] == 0) || ($value == 2 && $computer[$key] == 1)) {
                $result = "Gewonnen!";
                $won++;
            } elseif (($value == 0 && $computer[$key] == 1) || ($value == 1 && $computer[$key] == 2) || ($value == 2 && $computer[$key] == 0)) {
                $result = "Verloren!";
                $lost++;
            } else {
                $result = "Unentschieden!";
                $draw++;
            }

            #Result Row
            echo "<tr>
            <td> $key </td>
            <td>" .getName($user[$key]). ":" .getName($computer[$key]). "</td>
            <td> $result </td>
            </tr>";

        }
        #Table End
        echo "</table>";

    } else {
        echo "<div id=\"error\"> Bitte wählen Sie zuerst eine der Optionen aus. </div>";
    }
        
?>  


<?php
    function getName($index)
    {
        $zeichenArray = [
            0 => "Schere",
            1 => "Stein",
            2 => "Papier",
        ];
        return $zeichenArray[$index];
    }
?>

</body>
</html>