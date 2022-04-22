<?php
class Controller {
	private $request = null;
	private $template = "";
	private $view = null; //Rahmen-Template
	private $error;

	public function __construct($request) {
		$this->view = new View();
		$this->request = $request;
		// Default-View: verteiler_eintrag
		$this->template = !empty($request["view"]) ? $request["view"] : "verteiler_eintrag";
	}

	// Anzeigen des Contents
	public function display() {
		$view = new View(); 
		$model = new Model();
		
		//Innen-Template setzen
		switch ($this->template) {
			//Template für Benutzeransicht
			case "verteiler_ansicht": 
				$view->setTemplate("verteiler_ansicht");
				$entries = $model->getEntries();
				if (!$entries) {
					$this->error = $model->getError();
				} else {
					$view->assign("entries", $entries);
				}
				break;
			//Template zum Versenden von Emails
			case "verteiler_email":
				$view->setTemplate("verteiler_email");
				if (isset($this->request["betreff"], $this->request["nachricht"])) {
					$betreff = trim($this->request["betreff"]);
					$nachricht = trim($this->request["nachricht"]);
					// Fehler:
					if ($betreff == "") {
						$this->error = "Bitte Betreff ausfüllen!<br>";
					}
					if ($nachricht == "") {
						$this->error .= "Bitte Nachricht ausfüllen!<br>";
					}
					// Kein Fehler:
					if ($this->error == "") {	
						$emails = $model->getEmails($betreff, $nachricht);
						foreach($emails as $email){
							mail("$email[email]","$betreff","$nachricht"); ////
						}
					}
				}
				break;
			//Template zum Eintragen im Verteiler
			case "verteiler_eintrag":
			default:
				$view->setTemplate("verteiler_eintrag");
				if (isset($this->request["vorname"],
				          $this->request["nachname"],
						  $this->request["email"])) {
					$vorname = trim($this->request["vorname"]);
					$nachname = trim($this->request["nachname"]);
					$email = trim($this->request["email"]);
					// Fehler:
					if ($vorname == "") {
						$this->error = "Bitte Vorname ausfüllen!<br>";
					}
					if ($nachname == "") {
						$this->error .= "Bitte Nachname ausfüllen!<br>";
					}
					if ($email == "") {
						$this->error .= "Bitte Email-Adresse ausfüllen!<br>";
					}
					// Kein Fehler:
					if ($this->error == "") {
						$inserted = $model->insertEntry($vorname, $nachname, $email);
						if ($inserted) {
							header("Location: index.php?view=verteiler_ansicht");
						} else {
							$this->error = "Eintragen fehlgeschlagen. Bitte versuchen Sie es erneut.<br>";
						}
					}
				}
		}

		// Rahmen-Template
		$this->view->setTemplate("rahmen");
		// Innen-Template
		$this->view->assign("blog_error", $this->error);
		$this->view->assign("blog_content", $view->loadTemplate());
		
		return $this->view->loadTemplate();
	}
}	
?>