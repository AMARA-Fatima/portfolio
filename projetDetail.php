<?php

// Commencer par l'appel du controller
require("./controllers/projectController.php");
// instanciation de notre controller
$controller = new ProjectController;
// Appel de la methode qui permet de récpérer tous les projet (controllers/projectController.php)
$project = $controller->readOne($_GET["id"]);
// Définition  de la constante du titre de la page, que nous utilisons des le head
define("PAGE_TITLE", "Detail-Projet");

?>
<?php include("./assets/inc/head.php") ?>
<?php include("./assets/inc/header.php") ?>

<main class="flex-wrap justify-content-around carousel2">
    <!-- <?php var_dump($project) ?> -->

    <div class="container-fluid">

        <h1 class="text-decoration-underline text-center mb-5" href="">Detail du Projet <?= $project->name ?> :</h1>
    </div>
    </div>

    <div class="row ms-1">
        <div class="col-7">
            <?php
            foreach ($project->pictures as $picture) {
            ?>
                <img src="/portfolio/assets/img/projects/<?= $picture->path ?>" alt="<?= $picture->alt ?>" class="w-100 mb-5">
        </div>

        <div class="bg-black opacity-75 col-5">
            <h3 class="mt-5">Description : <br><?= $project->description ?></h3>
            <ul class="list-group list-group-flush mt-5">
                <p>Date_début : <?= $project->date_start ?></p>
                <p>Date_fin : <?= $project->date_end ?></p>
            </ul>
            <div class="mt-4 text-center">
                <a href="#" class="btn card-link bg-primary bg-lg text-white">Voir_site : <?= $project->link_site ?></a>
                <a href="#" class="btn card-link bg-primary bg-lg text-white">Voir_Git : <?= $project->link_git ?></a>
            </div>
            <div >
                <h3 class="text-decoration-underline mt-5">Competences :</h3>
                <ul>
                    <?php foreach ($project->skills as $skill) { ?>
                        <li><?= $skill->name ?></li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </div>
<?php
            }
?>
</main>
<?php include("./assets/inc/footer.php") ?>