<?php
// lancer la session
session_start();

define("PAGE_TITLE", "Accueil-Admin");

include("../assets/inc/head.php");
include("../assets/inc/header.php");


// var_dump($_SESSION);

require_once("../controllers/accountController.php");

$accountController = new AccountController;

// permet de vérifier que l'utilisateur soit connécté 
// cette ligne permet de vérifier la connexion 
$accountController->isLogged();

?>
<main class="container" id="formulaire">
    <h1>Espace administrateur :</h1>
    <p>Votre email : <?= $_SESSION["email"] ?></p>
    <div class="d-flex justify-content-center m-5">
        <a href="../admin/ajoutCompetence.php" class="btn btn-primary me-5">Ajouter une competence</a>
        <a href="../admin/ajoutProjet.php" class="me-5 btn btn-primary">Ajouter un projet</a>
    </div>
</main>

<?php include("../assets/inc/footer.php"); ?>