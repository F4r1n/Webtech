var msg = "";


// reguläre Ausdrücke
var patt_nname = /^[A-Za-z]'?[A-Za-z-\s]{1,28}$/;
// O'Connor, mit leerzeichen
var patt_plz = /^\d{5}$/; //5-Steelliger DE plz
var patt_std = /^[A-Za-z]{2,30}([ -][A-Za-z]{2,20})?$/;
// (.*)\s(.*)
var patt_str = /^[a-z]{2,20}([ -][a-z]{2,20})?[ ]?(Str[\.]?|Straße)?$/i;
// möglich z.B. Ba oder Ba-Li oder Ba-Li str. oder Straße, 
var patt_hnr = /^[1-9]\d{0,3}([a-zA-Z]|[ ][a-zA-Z])?$/;
//beginnt mit 1-9, 1-4-Stellige hausnummer, optional eine buchstabe,
// nicht zwingend nach einem leerzeichen
var patt_iban = /^[A-Z]{2}\d{20}$/i;
var patt_gb = /(^[1-9][0-9]{0,8}([,.][\d]{1,2})?$)|(^0([,.][\d]{1,2})?$)/;
// möglich z.B. 76676712,00 oder 0.38

function check_elem(element, pattern, max_len) {
	var patt = pattern;
	var elem = document.getElementById(element);
	var elem_val = elem.value;
	var elem_len = elem_val.length;
	if ((elem_len == 0) || (elem_val == "")) {
		elem.style.backgroundColor = "lightblue";
		elem.value = "?";
		msg = "Keine Eingabe:\n";
		write_msg();
		return false;
	}
	if (elem_len > max_len) { // max_length check
		elem.style.backgroundColor = "lightblue";
		msg = elem_len + " Zeichen. Maximale Länge ist aber " + max_len + ":";
		write_msg();
		return false;
	}
	if (!patt.test(elem_val)) {
		elem.style.backgroundColor = "lightpink";
		elem.value = "";
		msg = "Ungültige Zeichen oder Länge:\n";
		write_msg();
		return false;
	}
	return true;
}

function check_form() {
	clear_msg();
	var fehler = 0;
	if (check_elem("fname", patt_nname, 30) == false) {
		msg = "Kein gültiger Vorname.<br />";
		write_msg();
		fehler++;
	}
	if (check_elem("plz", patt_plz, 5) == false) {
		msg = "Keine gültige Postleitzahl.<br />";
		write_msg();
		fehler++;
	}
	if (check_elem("stadt", patt_std, 30) == false) {
		msg = "Keine gültige Stadt<br />";
		write_msg();
		fehler++;
	}
	if (check_elem("strasse", patt_str, 30) == false) {
		msg = "Keine gültige Straße.<br />";
		write_msg();
		fehler++;
	}
	if (check_elem("hausnummer", patt_hnr, 4) == false) {
		msg = "Keine gültige Hausnummer.<br />";
		write_msg();
		fehler++;
	}
	if (check_elem("iban", patt_iban, 24) == false) {
		msg = "IBAN ist ungültig.<br />";
		write_msg();
		fehler++;
	}
	if (check_elem("betrag", patt_gb, 10) == false) {
		msg = "Kein gültiger Beitrag.<br />";
		write_msg();
		fehler++;
	}
	
	if (fehler == 0) {
		alert("Keine Fehler.\nIhre Daten werden übermittelt."); 
		clear_msg();
		return true;
	} else if (fehler > 0) {
		alert(fehler + " Fehler.\nIhre Daten können nicht übermittelt werden."); 
		return false;
	}
}

function reset_form() {
	clear_msg();
	document.getElementById("fname").style.backgroundColor = "lightblue";
	document.getElementById("plz").style.backgroundColor = "lightblue";
	document.getElementById("stadt").style.backgroundColor = "lightblue";
	document.getElementById("strasse").style.backgroundColor = "lightblue";
	document.getElementById("hausnummer").style.backgroundColor = "lightblue";
	document.getElementById("iban").style.backgroundColor = "lightblue";
	document.getElementById("betrag").style.backgroundColor = "lightblue";
}

function write_msg() {
	document.getElementById("div_fm").style.display = "block";
	document.getElementById("div_fm").innerHTML += msg + "<br />";
}


function clear_msg() {
	document.getElementById("div_fm").innerHTML = "";
	document.getElementById("div_fm").style.display = "none";	
} 



