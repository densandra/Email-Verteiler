<?php

// MVC Klassen einbinden
include("classes/controller.php");
include("classes/model.php");
include("classes/view.php");

// $_GET und $_POST zusammenfassen
$request = array_merge($_GET, $_POST);
// Controller erstellen
$controller = new Controller($request);
// Inhalt der Webanwendung ausgeben
echo $controller->display();

?>