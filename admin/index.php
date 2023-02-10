<?php
session_start();
define("PAGE_TITLE", "Accueil Admin");

require_once("../controllers/accountController.php");
require("../controllers/skillController.php");
require("../controllers/projectController.php");


$accountController = new AccountController;
// Permet de vérifier que l'utilisateur soit connecté
$accountController->isLogged();



// Instanciation de notre controller
$controllerSkill = new SkillController;

$skills = $controllerSkill->readAll();

$controllerProject = new ProjectController;
$projects = $controllerProject->readAll();

include("../assets/inc/head.php");
include("../assets/inc/header.php");

?>
<main class="container text-center" id="formulaire">
    <h1>Espace administrateur :</h1>
    <p>Votre email : <?= $_SESSION["email"] ?></p>

    <nav id="navbar" class="navbar nav-menu">
        <ul>
            <li><a href="#skills" class="nav-link scrollto active"> <i class="bi bi-house-door"></i> <span>Compétences</span></a></li>
            <li><a href="#projects" class="nav-link scrollto"><i class="bi bi-pencil-square"></i> <span>Projets</span></a></li>
            <li><a href="#new" class="nav-link scrollto"><i class="bi bi-file-earmark-plus"></i> <span>Nouveau</span></a></li>
        </ul>
    </nav>

    <div class="justify-content-arround text-center mb-3 ">
        <div class="container" id="skills">
            <h2>Liste des compétence</h2>
            <table class="table table-light align-middle mt-3 text-center">
                <thead class="thead-light">
                    <tr>
                        <th> image </th>
                        <th> nom</th>
                        <th> level </th>
                        <th> action </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($skills as $skill) :
                    ?>
                        <tr>
                            <td style="width:10%;height:10%;">
                                <img style="width:100%;height:100%;" src="../assets/img/competences/<?= $skill->picture ?>" alt="<?= $skill->name ?>">
                            </td>
                            <td><?= $skill->name  ?></td>
                            <td><?php for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $skill->level) {
                                        echo "<i class= 'bi bi-star-fill'></i>";
                                    } else {
                                        echo '<i class="bi bi-star"></i>';
                                    }
                                } ?></td>
                            <td>
                                <a type="button" class="btn btnProject" href="../admin/modifierCompetence/<?= $skill->id_skill ?>">Modifier</a>
                                <a type="button" class="btn btnProject" href="<?= $skill->id_skill  ?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php
                    endforeach ?>
                </tbody>
            </table>
        </div>

        <div class="container" id="projects">
            <h2>Liste des projets</h2>
            <table class="table table-light align-middle mt-3 text-center">
                <thead class="thead-light">
                    <tr>
                        <th> image </th>
                        <th> nom</th>
                        <th> description </th>
                        <th> date de création </th>
                        <th> date de fin </th>
                        <th> lien du site </th>
                        <th> lien Github </th>
                        <th> action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($projects as $project) :
                    ?>
                        <tr>
                            <td style="width:10%;height:10%;">
                                <img style="width:100%;height:100%;" src="../assets/img/projects/<?= $project->cover ?>" alt="<?= $project->name ?>">
                            </td>
                            <td><?= $project->name ?></td>
                            <td><?= $project->description ?></td>
                            <td><?= $project->date_start ?></td>
                            <td><?= $project->date_end ?></td>
                            <td><?= $project->link_site ?></td>
                            <td><?= $project->link_git ?></td>
                            <td>
                                <a type="button" class="btn btnProject" href="../admin/modifierCompetence/<?= $skill->id_skill ?>">Modifier</a>
                                <a type="button" class="btn btnProject" href="<?= $skill->id_skill  ?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php
                    endforeach ?>
                </tbody>
            </table>
        </div>
        <div id="new">
            <a href="../admin/ajoutCompetence.php" class="btn btnProject">Ajouter une compétence</a>
            <a href="../admin/ajoutProjet.php" class="btn btnProject">Ajouter un projet</a>
        </div>

    </div>
</main>
