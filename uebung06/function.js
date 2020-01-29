var arrayDoors = [];
var result = {
    bleiben: {
        won: 0,
        lost: 0,
    },
    wechseln: {
        won: 0,
        lost: 0,
    }
}
var prozentBleiben = 0;
var prozentWechseln = 0;
var firstDoorID = "";

/**
 * Mischt ein Array variabler Länge
 * 
 * @param {*} a array, das es zu mischen gilt
 */
function shuffle(a) {
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
}

/**
 * Initialisierung der Funktionalität und Zurücksetzen des Spiels.
 */
function setup() {
    arrayDoors = ["goat1", "goat2", "car"];
    firstDoorID = "";
    arrayDoors = shuffle(arrayDoors);
    document.getElementById("door1").className = arrayDoors[0];
    document.getElementById("door2").className = arrayDoors[1];
    document.getElementById("door3").className = arrayDoors[2];
    document.getElementById("door1").src = "http://localhost/uebung06/doorClosed.png";
    document.getElementById("door2").src = "http://localhost/uebung06/doorClosed.png";
    document.getElementById("door3").src = "http://localhost/uebung06/doorClosed.png";
    document.getElementById("bleiben").innerHTML = "Chance beim Bleiben: " + prozentBleiben;
    document.getElementById("wechseln").innerHTML = "Chance beim Wechseln: " + prozentWechseln;
    document.getElementById("aufgabe").innerHTML = "Bitte eine der Türen anklicken!";
    updateStats();
}

/**
 * Zeigt die Statistiken an
 */
function updateStats() {
    document.getElementById("bleiben").innerHTML = "Chance beim Bleiben: " + prozentBleiben + "%";
    document.getElementById("wechseln").innerHTML = "Chance beim Wechseln: " + prozentWechseln + "%";
    document.getElementById("autos").innerHTML = "Autos: "+ (result["bleiben"]["won"] + result["wechseln"]["won"]);
    document.getElementById("ziegen").innerHTML = "Ziegen: " + (result["bleiben"]["lost"] + result["wechseln"]["lost"]);
}

/** 
 * Anpassend er Statistik Variable im Falle des Nicht-Änderns der Entscheidung der Tür beim zweiten klick.
 * 
 * @param {*} ergebnis Gewonnen oder Verloren (boolean)
 */
function geblieben(ergebnis){
    if (ergebnis){
        result["bleiben"]["won"] += 1;
        document.getElementById("aufgabe").innerHTML += " Sie haben gewonnen!"
    } else {
        result["bleiben"]["lost"] += 1;
        document.getElementById("aufgabe").innerHTML += " Sie haben verloren!"
    }
    prozentBleiben = parseFloat(((result["bleiben"]["won"] / (result["bleiben"]["won"] + result["bleiben"]["lost"])) * 100).toFixed(2));
}

/** 
 * Anpassend er Statistik Variable im Falle des Wechselns der Tür beim zweiten klick.
 * 
 * @param {*} ergebnis Gewonnen oder Verloren (boolean)
 */
function gewechselt(ergebnis) {
    if (ergebnis) {
        result["wechseln"]["won"] += 1;
        document.getElementById("aufgabe").innerHTML += " Sie haben gewonnen!"
    } else {
        result["wechseln"]["lost"] += 1;
        document.getElementById("aufgabe").innerHTML += " Sie haben verloren!"
    }
    prozentWechseln = parseFloat(((result["wechseln"]["won"] / (result["wechseln"]["won"] + result["wechseln"]["lost"])) * 100).toFixed(2));

}

/** 
 * Bildet das Öffnen der ersten Beiden Türen ab.
 * Die erste Tür ist in jedem Falle eine Ziege aber nie die Tür die man geklickt hat.
 * Die zweite Tür ist entsprechend Ziege oder Auto.
 * 
 * @param {*} id ID der zu öffnenden Tür
 */
function changePicture(id) {
    var htmlClass = document.getElementById(id).className;
    var generalSrc = "http://localhost/uebung06/";
    var goatSrc = generalSrc + "doorGoat.png";
    var carSrc = generalSrc + "doorCar.png";
    var rand = Math.floor((Math.random() * 2) + 1);
    var xhttp = new XMLHttpRequest();

    document.getElementById("aufgabe").innerHTML = "Bitte eine der Türen anklicken!";
    //error handling
    if (document.getElementById(id).src != "http://localhost/uebung06/doorClosed.png") {
        document.getElementById("aufgabe").innerHTML = "Bitte wählen Sie eine geschlossene Tür!";
    } else {
        if (arrayDoors.length == 3) {
            if (rand == 1 && htmlClass == "goat2") {
                htmlClass = "goat1";
            } else if (rand == 1 && htmlClass == "goat1") {
                htmlClass = "goat2";
            } else if (rand == 2 && htmlClass == "goat1") {
                htmlClass = "goat2"
            } else if (rand == 2 && htmlClass == "goat2") {
                htmlClass = "goat1"
            } else if (rand == 1 && htmlClass == "car") {
                htmlClass = "goat1"
            } else if (rand == 2 && htmlClass == "car") {
                htmlClass = "goat2"
            }
            firstDoorID = id;
        }

        if (htmlClass == "car") {
            xhttp.open("POST", carSrc, true);
        } else if (htmlClass == "goat1" || htmlClass == "goat2") {
            xhttp.open("POST", goatSrc, true);
        }

        xhttp.responseType = "blob";
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var blob = xhttp.response;
                var imgSrc = URL.createObjectURL(blob)
                //öffne Tür
                document.getElementsByClassName(htmlClass).door.src = imgSrc;
                
                //Statistiken anpassen
                if (arrayDoors.length == 2){
                    if (firstDoorID == id){
                        //geblieben
                        if (htmlClass == "car"){
                            geblieben(true);
                        } else {
                            geblieben(false);
                        }
                    } else{
                        //gewechselt
                        if (htmlClass == "car") {
                            gewechselt(true);
                        } else {
                            gewechselt(false);
                        }
                    }
                }

                //entferne aufgedeckte Tür aus array; -1 ist Element nicht gefunden
                if (arrayDoors.indexOf(htmlClass) != -1) {
                    arrayDoors.splice(arrayDoors.indexOf(htmlClass), 1);
                }
                if (arrayDoors.length==1){
                    openLastDoor(arrayDoors[0]);
                };
            }
        };
        xhttp.send();
    }
}

/** 
 * Öffnet die letzte Tür. Alternative zur Rekursion, da diese in JS nicht funktionieren wollte.
 * 
 * @param {*} klasse klasse der zu öffnenden Tür
 */
function openLastDoor(klasse) {
    var generalSrc = "http://localhost/uebung06/";
    var goatSrc = generalSrc + "doorGoat.png";
    var carSrc = generalSrc + "doorCar.png";
    var xhttp = new XMLHttpRequest();

    if (klasse == "car") {
        xhttp.open("POST", carSrc, true);
    } else if (klasse == "goat1" || klasse == "goat2") {
        xhttp.open("POST", goatSrc, true);
    }

    xhttp.responseType = "blob";
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var blob = xhttp.response;
            var imgSrc = URL.createObjectURL(blob)
            //öffne Tür
            document.getElementsByClassName(klasse).door.src = imgSrc;
        }
    };
    updateStats();
    xhttp.send();
}

/** 
 * Ausgelöst durch klicken des Ende-Buttons
 * Zeigt die Statistik in groß an
 */
function ende(){
    var stats = '<div class="kopf" id="stats">Statistiken <br> <span id = "bleiben" > Chance beim Bleiben: </span> <br><span id="wechseln">Chance beim wechseln: </span> <br><span id = "autos" > Autos: </span> <br><span id="ziegen">Ziegen: </span> <br>'
    document.body.innerHTML = stats;
    document.getElementById("stats").style = "text-align: center; padding-left: 800px; font-weight: 900; font-size: 2em";
    document.getElementById("stats").style.border = "none";
    document.getElementById("bleiben").innerHTML = "Chance beim Bleiben: " + prozentBleiben + "%";
    document.getElementById("wechseln").innerHTML = "Chance beim Wechseln: " + prozentWechseln + "%";
    document.getElementById("autos").innerHTML = result[bleiben][won] + result[wechseln][won];
    document.getElementById("ziegen").innerHTML = result[bleiben][lost] + result[wechseln][lost];
}