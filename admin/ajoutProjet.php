<?php

session_start();
define("PAGE_TITLE", "Ajout Projet");

require_once("../controllers/accountController.php");
require_once("../controllers/skillController.php");
require_once("../controllers/projectController.php");


$accountController = new AccountController;
// Permet de vérifier que l'utilisateur soit connecté
$accountController->isLogged();
$skillController = new SkillController;

$skills = $skillController->readAll();

$projectController = new ProjectController;

if (isset($_POST["submit"])) 
{
    // Envoi des informations du formulaire pour créer un nouveau projet
    $projectController = new ProjectController;

    // on appel la methode pour creer un nouveau projet dans la base de donnée
    $result = $projectController->createProject($_POST["name"], $_POST["description"], $_POST["date_start"], $_POST["date_end"], $_POST["link_site"], $_POST["link_git"], $_FILES["cover"], $_POST["skills"]);
}

?>
<?php include("../assets/inc/head.php"); ?>
<?php include("../assets/inc/header.php"); ?>


<main class="container" id="formulaire">
    <div class="container offset-1">
        <form action="#" method="POST" enctype="multipart/form-data" class="col-9 m-5">

            <h1 class="text-center">Ajout d'un nouveau projet :</h1>

        <?php
        if(isset($result)) {
            if($result["success"]) { ?>
                <div class="alert alert-success"><?= $result["message"] ?></div>
            <?php }
            else { ?>
                <div class="alert alert-danger"><?= $result["message"] ?></div>
            <?php }
        }
        ?>

            <label for="name">Nom du projet :</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Portfolio" required>


            <label for="description">Description du projet :</label>
            <textarea name="description" id="description" rows='5' cols='40' class="form-control" placeholder="ajouter votre description"></textarea>


            <label for="date_start">Date de début du projet :</label>
            <input type="date" name="date_start" id="date_start" class="form-control" required>

            <label for="date_end">Date de fin du projet :</label>
            <input type="date" name="date_end" id="date_end" class="form-control">

            <label for="link_site">Lien du site :</label>
            <input type="url" name="link_site" id="link_site" class="form-control" placeholder="https://example.com">

            <label for="link_git">Lien GitHub :</label>
            <input type="url" name="link_git" id="link_git" class="form-control" placeholder="https://example.com">


            <label for="cover">Image principale :</label>
            <input type="file" name="cover" id="cover" class="form-control">

            <label for="skills" class="d-flex">Compétences :</label>
            <select name="skills[]" id="skills" multiple>
                <?php foreach ($skills as $skill) { ?>
                    <option value="<?= $skill->id_skill ?>"><?= $skill->name ?></option>
                <?php } ?>
            </select>
            <br>
            <button type="submit" name="submit" class="btn btn-primary mt-4 offset-5">Ajouter</button>
        </form>

            <a href="../admin/index.php" class="btn btn-success mb-5 offset-4">Retour</a>
    </div>
</main>
<?php include("../assets/inc/footer.php");


?>