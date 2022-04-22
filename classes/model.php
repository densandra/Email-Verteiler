<?php
class Model {
	private $cn;
	private $error;
	
	function __construct() {
		require("config.php");
		$this->cn = $cn;
	}
	
	function getError() {
		return $this->error;
	}

	// Formulardaten in Verteiler einfügen
	public function insertEntry($vorname, $nachname, $email) {
		// SQL-Injection verhindern
		$vorname = mysqli_real_escape_string($this->cn, $vorname);
		$nachname = mysqli_real_escape_string($this->cn, $nachname);
		$email = mysqli_real_escape_string($this->cn, $email);
		
		// HTML-Injection verhindern
		$vorname = htmlspecialchars($vorname);
		$nachname = htmlspecialchars($nachname);
		$email = htmlspecialchars($email);
		
		$sql = "INSERT verteiler
				SET vorname = '$vorname',
				nachname = '$nachname',
				email = '$email'";
		mysqli_query($this->cn, $sql);

		$error = mysqli_error($this->cn);
		if ($error) {
			$this->error = $error;
			return false;
		}

		return true;
	}

	// Alle eingetragenen Benutzer ausgeben
	public function getEntries() {
		$sql = "SELECT vorname, nachname, email,
				DATE_FORMAT(zeitstempel,'%d.%m.%Y %T') AS zeitstempel
				FROM verteiler
				ORDER BY nachname";
		$result = mysqli_query($this->cn, $sql);

		// SQL-Fehler abfragen
		if(!$result) {
			$this->error = mysqli_error($this->cn);
			return false;
		}

		// Array mit allen Benutzerdaten
		$entries = array();
		while($row = mysqli_fetch_assoc($result)) {
			$entries[] = $row;
		}
		return $entries;
	}
	
	// Alle eingetragenen Emailadressen ausgeben
	public function getEmails($betreff, $nachricht){
		//SQL-Injection verhindern
		$betreff = mysqli_real_escape_string($this->cn, $betreff);
		$nachricht = mysqli_real_escape_string($this->cn, $nachricht);
		
		//HTML-Injection verhindern
		$betreff = htmlspecialchars($betreff);
		$nachricht = htmlspecialchars($nachricht);
		
		$sql = "SELECT email
				FROM verteiler";
		$result = mysqli_query($this->cn, $sql);

		//SQL-Fehler abfragen
		if (!$result) {
			$this->error = mysqli_error($this->cn);
			return false;
		}

		// Array mit allen Emailadressen
		$emails = array();
		while($row = mysqli_fetch_assoc($result)) {
			$emails[] = $row;
		}
		return $emails;
	}
}
?>