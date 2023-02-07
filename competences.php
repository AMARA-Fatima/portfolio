<?php

// Commencer par l'appel du controller
require("./controllers/skillController.php");
// instanciation de notre controller
$controller = new SkillController;
// Appel de la methode qui permet de récpérer tous les projet (controllers/projectController.php)
$skills = $controller->readAll(); // refaire
// Définition  de la constante du titre de la page, que nous utilisons des le head
define("PAGE_TITLE", "competences");

include("./assets/inc/head.php");
include("./assets/inc/header.php");
?>

<main class="carousel2">

    <!-- TODO : afficher les skills grace à une boucle -->
    <div class="container d-flex flex-wrap justify-content-around">
        <h1 class="mb-5 text-decoration-underline">Liste des comptences :</h1>
        <div class="row">
            <!-- <?php var_dump($skills) ?> -->

            <?php
            foreach ($skills as $skill) {
            ?>
                <div class="card text-dark mb-3 ms-4" style="width: 15rem;">
                    <img src="/portfolio/assets/img/competences/<?= $skill->picture ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h1><?= $skill->name ?></h1>
                        <h2>
                            <i>
                                <?php for ($i = 1; $i <= 5; $i++)
                                {
                                    // echo '<i class="bi bi-star"> </i>';
                                    if($i <= $skill->level)
                                    {
                                        echo '<i class="bi bi-star-fill"></i>';
                                    }
                                 else
                                    {
                                        echo '<i class="bi bi-star"></i>';
                                    }
                                }
                                ?>
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