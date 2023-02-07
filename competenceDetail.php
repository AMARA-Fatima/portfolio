<?php

// Commencer par l'appel du controller
require("./controllers/skillController.php");
// instanciation de notre controller
$controller = new SkillController;
// Appel de la methode qui permet de récpérer tous les projet (controllers/projectController.php)
$skill = $controller->readOne($_GET["id"]);
// Définition  de la constante du titre de la page, que nous utilisons des le head
define("PAGE_TITLE", "Detail Skill");

?>