<?php
    session_start();
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
        und diese mit dem "Absenden"-Button gesendet wurde wird die Eingabe gegen eine zufällige Auswahl des Computers aufgestellt. Dabei gelten folgende Wertigkeiten: <br>
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
    if (!isset($_SESSION['iteration']) || $_SESSION["iteration"] == 5){
        $_SESSION["iteration"] = 0;
        $_SESSION["won"] = 0;
        $_SESSION["lost"] = 0;
        $_SESSION["draw"] = 0;
        $_SESSION["user"] = array();
        $_SESSION["computer"] = array();
        $_SESSION["standings"] = array();
    }

    if (isset($_POST['submit']) && isset($_POST['userInput'])) {
        array_push($_SESSION["user"], $_POST['userInput']);
        array_push($_SESSION["computer"], rand(0, 2));
        
        $human = $_SESSION["user"][$_SESSION["iteration"]];
        $comp = $_SESSION["computer"][$_SESSION["iteration"]];
        $_SESSION["iteration"]++;


        if(($human == 0 && $comp == 2) || ($human == 1 && $comp == 0) || ($human == 2 && $comp == 1)) {
                $result = "Gewonnen!";
                array_push($_SESSION["standings"], 0);
                $_SESSION["won"]++;
            } elseif (($human == 0 && $comp == 1) || ($human == 1 && $comp == 2) || ($human == 2 && $comp == 0)) {
                $result = "Verloren!";
                array_push($_SESSION["standings"], 1);
                $_SESSION["lost"]++;
            } else {
                $result = "Unentschieden!";
                array_push($_SESSION["standings"], 2);
                $_SESSION["draw"]++;
        }

        #Table Start
        echo "<table>
        <tr>
            <th> Runde </th>
            <th> Eingaben (User:PC) </th>
            <th> Ergebnis </th>
        </tr>";

        foreach($_SESSION["user"] as $key => $value){
            $runde = $key + 1;
            #Result Row
            echo "<tr>
            <td> $runde </td>
            <td>" .getName($_SESSION["user"][$key]). ":" .getName($_SESSION["computer"][$key]). "</td>
            <td>" .getResult($_SESSION["standings"][$key]). "</td>
            </tr>";
        }
    echo "</table>";

    #Evaluate overall result
    if ($_SESSION["won"] > $_SESSION["lost"]) {
        $bo5 = "Gewonnen!";
    } else if ($_SESSION["won"] < $_SESSION["lost"]) {
        $bo5 = "Verloren!";
    } else {
        $bo5 = "ein Unentschieden erreicht!";
    }

    if ($_SESSION['iteration'] == 5){
        echo "<span id=\"result\"> Ergebnis: " .$_SESSION["won"]. " : " .$_SESSION["lost"]. " (Unentschieden: " .$_SESSION["draw"].") </span> <br>";
        echo "<span id=\"result\"> Damit haben Sie gegen den Computer im BestOfFive $bo5</span>";
    }
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

    function getResult($index)
    {
        $resultArray = [
            0 => "Gewonnen",
            1 => "Verloren",
            2 => "Unentschieden",
        ];
        return $resultArray[$index];
    }
?>

</body>
</html>