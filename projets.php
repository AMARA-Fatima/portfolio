<?php

// Commencer par l'appel du controller
require("./controllers/projectController.php");
// instanciation de notre controller
$controller = new ProjectController;
// Appel de la methode qui permet de récpérer tous les projet (controllers/projectController.php)
$projects = $controller->readAll();
// Définition  de la constante du titre de la page, que nous utilisons des le head
define("PAGE_TITLE", "Projets");

?>
<?php include("./assets/inc/head.php") ?>
<?php include("./assets/inc/header.php") ?>

<main class="d-flex ">

    <!-- <?php var_dump($projects) ?> -->

    <?php
    foreach ($projects as $project) {
        $project->afficherProjects();
    }
    ?>
</main>

<?php include("./assets/inc/footer.php") ?>