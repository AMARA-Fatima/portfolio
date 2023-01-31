<?php

// Commencer par l'appel du controller
require("./controllers/skillController.php");
// instanciation de notre controller
$controller = new SkillController;
// Appel de la methode qui permet de récpérer tous les projet (controllers/projectController.php)
$competences = $controller->readAll(); // refaire
// Définition  de la constante du titre de la page, que nous utilisons des le head
define("PAGE_TITLE", "Competences");

include("./assets/inc/head.php");
include("./assets/inc/header.php");
?>

<main class="carousel2">

    <!-- TODO : afficher les competences grace à une boucle -->
    <div class="container d-flex flex-wrap justify-content-around">
        <h1 class="mb-5 text-decoration-underline">Liste des competences :</h1>
        <div class="row">
            <!-- <?php var_dump($competences) ?> -->

            <?php
            foreach ($competences as $competence) {
            ?>
                <div class="card text-dark mb-3 ms-4" style="width: 15rem;">
                    <img src="/portfolio/assets/img/competences/<?= $competence->picture ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h1><?= $competence->name ?></h1>
                        <h2>
                            <i>
                                mettre le level
                                <!-- <?php for ($competence->level = 1;; $competence->level++) {
                                            break;
                                        }
                                        echo '<i class="bi bi-star">';
                                        ?> -->
                            </i>
                        </h2>
                        <p class="card-text">bla bla bla bla bla</p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</main>

<?php include("./assets/inc/footer.php") ?>