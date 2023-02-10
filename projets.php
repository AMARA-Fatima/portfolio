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
<?php include("./assets/inc/head.php")?>
<?php include("./assets/inc/header.php")?>

<main class="d-flex flex-wrap justify-content-around carousel">


    <div class="container-fluid">
        <div class="row">
            <div id="carouselExampleDark" class="carousel slide" data-bs-ride="carousel">
                <h1 class="text-decoration-underline mb-2">Liste des projets :</h1>
                <div class="carousel-inner">

                    <?php foreach ($projects as $key => $project) { ?>

                        <div class="carousel-item text-center <?= ($key == 0 ? 'active' : '') ?> ">
                            <img src="/portfolio/assets/img/projects/<?= $project->cover ?>" alt="" class="imgcr d-block w-100">
                            <div class="bg-black opacity-75">
                                <h2 class="title"><?= $project->name ?></h2>
                                <p>Description : <br><?= $project->description ?></p>
                                <a href="/portfolio/projet/<?= $project->id_project ?>" class="btn card-link bg-primary bg-lg text-white mb-5">Detail > </a>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include("./assets/inc/footer.php") ?>