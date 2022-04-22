<?php
class View {
	// Pfad zum Template
	private $path = "templates";
	// Namen des Templates
	private $template = "verteiler_eintrag";
	// Variablen, die in das Template eingebettet werden sollen
	private $_ = array();

	// Ordnet eine Variable einem Schlüssel zu
	public function assign($key, $value) {
		$this->_[$key] = $value;
	}

	// Setzt den Namen des Templates
	public function setTemplate($template = "verteiler_eintrag") {
		$this->template = $template;
	}

	// Template-File laden
	public function loadTemplate() {
		// Pfad zum Template erstellen und prüfen, ob Template existiert
		$file = $this->path . "/" . $this->template . ".php";
		$exists = file_exists($file);

		if ($exists) {
			// Template-File einbinden und Output in Buffer speichern
			ob_start();
			include $file;
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		} else {
			return "Template konnte nicht gefunden werden!";
		}
	}
}
?>